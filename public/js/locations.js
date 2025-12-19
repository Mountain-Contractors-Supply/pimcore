(function() {

class LocationsMap {
    constructor() {
        this.options = {
            mapId: "43d9490d75fc2c0e",
            center: { lat: 39.8283, lng: -98.5795 },
            zoom: 4,
            disableDefaultUI: false,
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: true,
            streetViewControl: false,
            rotateControl: false,
            fullscreenControl: true,
            gestureHandling: 'greedy',
            clickableIcons: false
        };

        this.markers = [];
        this.infoWindows = [];
        this.currentInfoWindow = null;
        this.userLocation = null;
        this.hasUserInteracted = false;
        this.isLoaded = false;

        this.bindMethods();
    }
    
    static getInstance() {
        if (!LocationsMap._instance) {
            LocationsMap._instance = new LocationsMap();
        }
        return LocationsMap._instance;
    }

    bindMethods() {
        const methods = Object.getOwnPropertyNames(LocationsMap.prototype)
            .filter(prop => typeof this[prop] === 'function' && prop !== 'constructor');
        methods.forEach(method => {
            this[method] = this[method].bind(this);
        });
    }
    
    normalizeProductType(t) {
        if (t && typeof t === 'object') {
            const name = t.name ?? (t.productTypeId ? String(t.productTypeId) : '');
            const icon = t.icon ?? null;
            return { name, icon, productTypeId: t.productTypeId };
        }
        return { name: String(t), icon: null, productTypeId: null };
    }
    
    sanitizePhoneNumber(number) {
        // Allow only digits, +, -, space, and parentheses
        return String(number || '').replace(/[^0-9+\-\s()]/g, '').trim();
    }
    
    sanitizeLabel(label) {
        // Remove any HTML tags and trim
        return String(label || '').replace(/<[^>]*>/g, '').trim();
    }

    escapeHtml(value) {
        const str = String(value ?? '');
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
    
    buildProductServicesHtml(normalizedProductTypes) {
        if (normalizedProductTypes.length === 0) return '';
        return `
            <div class="location-services">
                ${normalizedProductTypes.map(s => {
                    const iconHtml = s.icon ? `<img src="${s.icon}" alt="${s.name}" style="height: 16px; margin-right: 4px; vertical-align: middle;">` : '';
                    return `<span class="service-tag">${iconHtml}${s.name}</span>`;
                }).join('')}
            </div>
        `;
    }
    
    buildPhoneContactHtml(phoneNumbers) {
        if (phoneNumbers.length === 0) return '';
        return phoneNumbers.map(phoneData => {
            const safeLabel = this.escapeHtml(phoneData.label);
            const safeNumber = this.escapeHtml(phoneData.number);
            return `<div class="location-contact">📞 <span class="phone-label">${safeLabel}:</span> <a href="tel:${safeNumber}">${safeNumber}</a></div>`;
        }).join('');
    }
    
    buildPhoneCallPanel(phoneNumbers) {
        if (phoneNumbers.length === 0) return '';
        const phonePanelContent = phoneNumbers.map(phoneData => {
            const safeLabel = this.escapeHtml(phoneData.label);
            const safeNumber = this.escapeHtml(phoneData.number);
            return `
                <div class="phone-number-item">
                    <div class="phone-number-label">${safeLabel}</div>
                    <div class="phone-number">${safeNumber}</div>
                    <div class="call-options">
                        <a href="tel:${safeNumber}" class="call-option-btn primary">Call</a>
                        <button class="call-option-btn secondary" onclick="copyPhoneNumber('${safeNumber}')">Copy</button>
                    </div>
                </div>
            `;
        }).join('');
        return `
                <button class="call-btn"><p>Call</p></button>
                <div class="phone-panel">
                    <button class="phone-panel-close" aria-label="Close phone panel">&times;</button>
                    ${phonePanelContent}
                </div>
            `;
    }
    
    normalizePhoneNumbers(location) {
        if (!location) return [];
        const phones = [];

        if (Array.isArray(location.phoneNumbers)) {
            location.phoneNumbers.forEach((p) => {
                if (p?.phoneNumber) {
                    const label = this.sanitizeLabel(p.phoneNumberText || 'Phone');
                    phones.push({
                        label,
                        number: this.sanitizePhoneNumber(p.phoneNumber),
                    });
                }
            });
        }

        if (phones.length === 0 && location.phone) {
            phones.push({ label: 'Phone', number: this.sanitizePhoneNumber(location.phone) });
        }

        return phones;
    }
    async init() {
        try {
            await this.loadGoogleMapsAPI();
            await this.fetchLocations();
            await this.initializeMap();
            this.setupFiltering();
            this.applyURLParams();
            this.applyFilters();
            setTimeout(() => setupPhonePanels(), 100);
            this.isLoaded = true;
            return true;
        } catch (error) {
            this.showMapError(error.message);
            return false;
        }
    }
    
    async loadGoogleMapsAPI() {
        const timeoutMs = 20000;
        const waitForGoogle = new Promise((resolve) => {
            if (typeof google !== 'undefined' && google.maps) {
                resolve();
                return;
            }
            const checkGoogleMaps = () => {
                if (typeof google !== 'undefined' && google.maps) {
                    resolve();
                } else {
                    setTimeout(checkGoogleMaps, 200);
                }
            };
            checkGoogleMaps();
        });

        const timeout = new Promise((_, reject) => {
            setTimeout(() => {
                reject(new Error(`Google Maps API load timed out after ${timeoutMs / 1000}s`));
            }, timeoutMs);
        });

        return Promise.race([waitForGoogle, timeout]);
    }

    async fetchLocations() {
        try {
            const response = await fetch("/branches", {
                method: 'GET',
            });
            if (!response.ok) {
                throw new Error(`Locations fetch failed: ${response.status}`);
            }
            const result = await response.json();
            let locations = Array.isArray(result) ? result : (result.locations || []);

            locations.sort((a, b) => {
                const stateA = (a.address?.state || '').toUpperCase();
                const stateB = (b.address?.state || '').toUpperCase();
                const nameA = (a.name || '').toUpperCase();
                const nameB = (b.name || '').toUpperCase();
                
                if (stateA < stateB) return -1;
                if (stateA > stateB) return 1;
                if (nameA < nameB) return -1;
                if (nameA > nameB) return 1;
                return 0;
            });

            console.log(`✅ Loaded ${locations.length} locations (sorted by state, then name)`);
            
            window.MountainlandApp.locations = locations;
            
            const locationCountMap = document.getElementById('location-count-map');
            if (locationCountMap) {
                locationCountMap.textContent = locations.length;
            }
            
            const stateCountMap = document.getElementById('state-count-map');
            if (stateCountMap) {
                const uniqueStates = new Set(locations.map(loc => loc.address?.state).filter(Boolean));
                stateCountMap.textContent = uniqueStates.size;
            }
            window.MountainlandApp.filteredLocations = [...locations];
            return locations;
        } catch (error) {
            return [];
        }
    }

    async initializeMap() {
        try {
            const mapContainer = document.getElementById("map-wrapper");
            if (!mapContainer) {
                throw new Error("Map container not found");
            }
            window.MountainlandApp.map = new google.maps.Map(mapContainer, this.options);
            if (!window.MountainlandApp.map) {
                throw new Error("Map failed to initialize");
            }
            await this.addMarkersToMap();
            this.isLoaded = true;
            window.dispatchEvent(new CustomEvent('mapLoaded', {
                detail: {
                    map: window.MountainlandApp.map,
                    locations: window.MountainlandApp.locations
                }
            }));
        } catch (error) {
            this.showMapError(`Failed to initialize map: ${error.message}`);
        }
    }
    
    setupFiltering() {
        const filterInputs = document.querySelectorAll('input[name="branch-type"]');
        if (filterInputs.length === 0) {
            return;
        }
        this.setupSearch();
    }
    
    setupSearch() {
        const searchInput = document.getElementById('search-input');
        if (!searchInput) return;
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('search-now-btn')?.click();
            }
        });
    }
    
    applyFilters() {
        const searchTerm = document.getElementById('search-input')?.value.trim() || '';
        const radius = document.getElementById('radius-select')?.value || '25';
        const activeFilters = this.getActiveFilters();
        
        let results = [...window.MountainlandApp.locations];

        if (searchTerm) {
            const termLower = searchTerm.toLowerCase();
            results = results.filter(location => {
                const name = location.name || location.title || '';
                const address = location.address 
                    ? (typeof location.address === 'string' 
                        ? location.address 
                        : `${location.address.line1}, ${location.address.city}`)
                    : '';
                const city = location.address?.city || location.city || '';
                
                return name.toLowerCase().includes(termLower) ||
                       address.toLowerCase().includes(termLower) ||
                       city.toLowerCase().includes(termLower);
            });
        }

        if (activeFilters.length > 0) {
            results = results.filter(location => {
                const productTypes = Array.isArray(location.productTypes) ? location.productTypes : [];
                const locTypes = productTypes
                    .map(t => this.normalizeProductType(t))
                    .map(pt => pt.productTypeId)
                    .filter(Boolean)
                    .map(id => id.toLowerCase());
                
                return activeFilters.every(f => locTypes.includes(String(f).toLowerCase()));
            });
        }

        const userLoc = window.MountainlandApp.userLocation || this.userLocation;
        if (userLoc) {
            const maxMeters = parseInt(radius) * 1609.34;
            results = results.filter(location => {
                const coords = this.getValidCoordinates(location);
                if (!coords) return false;
                
                const distance = window.haversineFormula(
                    userLoc.lat,
                    userLoc.lng,
                    coords.lat,
                    coords.lng
                );
                return distance <= maxMeters;
            });
            
            results = this.sortByDistance(results);
        }

        window.MountainlandApp.filteredLocations = results;
        
        this.addMarkersToMap(results);
        this.updateLocationList(results);
        
        setTimeout(() => setupPhonePanels(), 50);
        
        this.updateURLParams();
    }
    
    getActiveFilters() {
        const activeFilters = [];
        document.querySelectorAll('input[name="branch-type"]:checked').forEach(input => {
            if (input.value) activeFilters.push(input.value);
        });
        return activeFilters;
    }
    
    async addMarkersToMap(locationsToShow = null) {
        if (!window.google || !window.google.maps) {
            return;
        }
        const locations = locationsToShow || window.MountainlandApp.filteredLocations;
        const map = window.MountainlandApp.map;
        if (!map) {
            return;
        }
        if (!locations || locations.length === 0) {
            this.clearMarkers();
            return;
        }
                
        const bounds = new google.maps.LatLngBounds();
        let markersAdded = 0;
        
        this.clearMarkers();
        
        for (const location of locations) {
            const coords = this.getValidCoordinates(location);
            if (!coords) continue;
            
            try {
                const marker = new google.maps.Marker({
                    position: coords,
                    map: map,
                    title: location.name || location.title || "Location",
                    clickable: true,
                    cursor: 'pointer',
                    optimized: false
                });
                
                const infoWindow = new google.maps.InfoWindow({
                    content: this.createInfoWindowContent(location),
                    maxWidth: 300
                });
                
                marker.addListener('click', () => {
                    if (this.currentInfoWindow) {
                        this.currentInfoWindow.close();
                    }
                    
                    infoWindow.open(map, marker);
                    this.currentInfoWindow = infoWindow;
                    
                    map.panTo(marker.getPosition());
                });
                
                this.markers.push(marker);
                this.infoWindows.push(infoWindow);
                
                bounds.extend(coords);
                markersAdded++;
            } catch (error) {
            }
        }
        
        if (markersAdded > 1) {
            map.fitBounds(bounds);
        } else if (markersAdded === 1) {
            map.setCenter(this.getValidCoordinates(locations[0]));
            map.setZoom(12);
        }
    }
    
    clearMarkers() {
        if (!this.markers) this.markers = [];
        if (!this.infoWindows) this.infoWindows = [];
        this.markers.forEach(marker => {
            if (marker) marker.setMap(null);
        });
        this.infoWindows.forEach(infoWindow => {
            if (infoWindow) infoWindow.close();
        });
        this.markers = [];
        this.infoWindows = [];
    }
    
    updateURLParams() {
        const checkedTypes = Array.from(
            document.querySelectorAll('input[name="branch-type"]:checked')
        ).map(cb => cb.value);
        const radius = document.getElementById("radius-select")?.value;
        const params = new URLSearchParams();
        if (checkedTypes.length > 0) params.set("types", checkedTypes.join(","));
        if (radius) params.set("radius", radius);
        history.replaceState({}, '', `${window.location.pathname}?${params.toString()}`);
    }
    
    applyURLParams() {
        const params = new URLSearchParams(window.location.search);
        const types = params.get("types");
        const radius = params.get("radius");
        if (types) {
            const typeArray = types.split(",");
            document.querySelectorAll('input[name="branch-type"]').forEach((cb) => {
                cb.checked = typeArray.includes(cb.value);
            });
        }
        if (radius) {
            const radiusSelect = document.getElementById("radius-select");
            if (radiusSelect) radiusSelect.value = radius;
        }
    }
    
    getValidCoordinates(location) {
        let lat, lng;
        if (location.address && location.address.coordinates) {
            lat = location.address.coordinates.latitude;
            lng = location.address.coordinates.longitude;
        } else {
            return null;
        }
        if (typeof lat !== 'number' || typeof lng !== 'number' ||
            isNaN(lat) || isNaN(lng) ||
            lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                return null;
        }
        return { lat, lng };
    }
    
    showMapError(message) {
        const mapContainer = document.getElementById("map-wrapper");
        if (mapContainer) {
            mapContainer.innerHTML = `
                <div style="color: #666; text-align: center; padding: 2rem;">
                    <div>
                        <h3 style="color: #11175e;">🗺️ Map Loading Error</h3>
                        <p>${message}</p>
                        <button onclick="location.reload()" style="padding: 8px 16px; background: #11175e; color: white; border: none; cursor: pointer; border-radius: 4px;">
                            Retry
                        </button>
                    </div>
                </div>
            `;
        }
    }
    
    createInfoWindowContent(location) {
        const title = location.name || location.title || "Location";
        const address = formatAddress(location.address);
        const addressForMaps = encodeURIComponent(address);
        const directionsUrl = `https://www.google.com/maps/dir/?api=1&destination=${addressForMaps}`;
        let content = `
            <div style="padding: 16px;">
                <div style="min-width: 220px; max-width: 300px; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 10px;">
                    <h3 style="margin: 0; color: #11175e; font-size: 14px; font-weight: 600;">${title}</h3>
                    <div style="color: #666; font-size: 13px;">📍 ${address}</div>
        `;
        const phoneNumbers = this.normalizePhoneNumbers(location);
        if (phoneNumbers.length > 0) {
            content += `<div style="color: #666; font-size: 13px;">`;
            phoneNumbers.forEach((phoneData, index) => {
                const safeLabel = this.escapeHtml(phoneData.label);
                const safeNumber = this.escapeHtml(phoneData.number);
                if (index > 0) content += `<br>`;
                content += `📞 <a href="tel:${safeNumber}" style="color: #11175e; text-decoration: none;">${safeLabel}: ${safeNumber}</a>`;
            });
            content += `</div>`;
        }
        if (location.hours) {
            const hoursText = formatHours(location.hours);
            if (hoursText) {
                content += `<div style="color: #666; font-size: 13px;">🕒 ${hoursText}</div>`;
            }
        }
        content += `
                    <div style="margin-top: 4px;">
                        <a href="${directionsUrl}" target="_blank" style="display: inline-block; padding: 8px 16px; background-color: #11175e; color: white; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">Get Directions</a>
                    </div>
                </div>
            </div>
        `;
        return content;
    }
    
    updateLocationList(locations) {
        this.populateLocationList(locations);
    }

    populateLocationList(locationsToShow = null) {
        const locationList = document.getElementById('location-list');
        const locationCount = document.getElementById('location-count');
        const filteredLocationCount = document.getElementById('filtered-location-count');
        const locations = locationsToShow || window.MountainlandApp.filteredLocations;

        if (!locationList) {
            return;
        }
        if (!locationCount) {
        }
        
        if (filteredLocationCount) {
            filteredLocationCount.textContent = locations.length;
        }

        if (locations.length > 0) {
            locationList.innerHTML = locations.map(loc => this.createLocationListItem(loc)).join('');
            setTimeout(() => setupPhonePanels(), 50);
        } else {
            locationList.innerHTML = `
                <div class="no-results">
                    <p>No locations found matching your criteria.</p>
                    <p>Try adjusting your filters or search terms.</p>
                </div>
            `;
        }
    }
    
    createLocationListItem(location) {
        let distanceText = '';
        const userLoc = window.MountainlandApp.userLocation || this.userLocation;
        if (userLoc) {
            const coords = this.getValidCoordinates(location);
            if (coords) {
                const distance = window.haversineFormula(userLoc.lat, userLoc.lng, coords.lat, coords.lng);
                const miles = (distance / 1609.34).toFixed(1);
                distanceText = `${miles} ${miles === '1.0' ? 'mile' : 'miles'} away`;
            }
        }
        
        const productTypes = Array.isArray(location.productTypes) ? location.productTypes : [];
        const normalizedProductTypes = productTypes.map(pt => this.normalizeProductType(pt));
        const servicesHtml = this.buildProductServicesHtml(normalizedProductTypes);
        
        const phoneNumbers = this.normalizePhoneNumbers(location);
        const contactHtml = this.buildPhoneContactHtml(phoneNumbers);
        
        const hoursText = formatHours(location.hours);
        const hoursHtml = hoursText ? 
            `<div class="location-contact">🕒 ${hoursText}</div>` : '';
        
        const address = formatAddress(location.address);
        const addressForMaps = encodeURIComponent(address);
        const directionsHtml = addressForMaps ? `
            <a href="https://www.google.com/maps/dir/?api=1&destination=${addressForMaps}" target="_blank" class="directions-btn"><p>Directions</p></a>
        ` : '';
        
        const callHtml = this.buildPhoneCallPanel(phoneNumbers);
        const mainStoreHtml = location.isValidForCurrentOnlineStore
            ? `<button class="main-store-btn" data-branch-id="${location.id}" data-branch-code="${location.branchId}"><p>Select Branch</p></button>`
            : '';
        const buttonsHtml = (directionsHtml || callHtml || mainStoreHtml) ? `
            <div class="location-actions">
                ${directionsHtml}
                ${callHtml}
                ${mainStoreHtml}
            </div>
        ` : '';

        const hoursTableHtml = renderHoursTable(location.hours, contactHtml);
        const locationName = location.name || location.companyName || location.title || 'Location';
        const locationId = location.id || locationName;
        
        const statusInfo = isLocationOpen(location.hours);
        let statusBubble = '';
        if (statusInfo) {
            const statusClass = statusInfo.isOpen ? 'open' : 'closed';
            const statusText = statusInfo.isOpen ? 'Open' : 'Closed';
            statusBubble = `<span class="status-badge ${statusClass}" title="${statusInfo.nextChange}">${statusText}</span>`;
        }
        
        const verticle = location.verticle || '';
        const verticleHtml = verticle ? `<div class="location-verticle">${verticle}</div>` : '';
        
        return `
            <div class="location-item" onclick="window.mapsLoader.focusLocation('${locationId}')">
                <div class="location-main">
                    <h4>${locationName}${statusBubble}</h4>
                    ${verticleHtml}
                    ${distanceText ? `<div class="location-distance-below">${distanceText}</div>` : ''}
                    <div class="location-address">📍 ${address || 'Address not available'}</div>
                    ${servicesHtml}
                    ${buttonsHtml}
                </div>
                ${hoursTableHtml}
            </div>
        `;
    }
    
    focusLocation(locationId) {
        const location = window.MountainlandApp.filteredLocations.find(
            loc => (loc.id || loc.name || loc.title) === locationId
        );
        if (location && window.MountainlandApp.map) {
            const coords = this.getValidCoordinates(location);
            if (coords) {
                window.MountainlandApp.map.setCenter(coords);
                window.MountainlandApp.map.setZoom(15);
                const markerIndex = window.MountainlandApp.filteredLocations.findIndex(
                    loc => (loc.id || loc.name || loc.title) === locationId
                );
                if (markerIndex >= 0 && this.markers[markerIndex]) {
                    google.maps.event.trigger(this.markers[markerIndex], 'click');
                }
            }
        }
    }
    
    sortByDistance(locations) {
        const userLoc = window.MountainlandApp.userLocation || this.userLocation;
        if (!userLoc) return locations;
        return locations.slice().sort((a, b) => {
            const coordsA = a.coords || a.location;
            const coordsB = b.coords || b.location;
            if (!coordsA || !coordsB) return 0;
            const distA = window.haversineFormula(userLoc.lat, userLoc.lng, coordsA.lat, coordsA.lng);
            const distB = window.haversineFormula(userLoc.lat, userLoc.lng, coordsB.lat, coordsB.lng);
            return distA - distB;
        });
    }
}

function geocodeZipCode(zipCode) {
    if (!zipCode.trim()) {
        return;
    }

    if (!window.google || !window.google.maps) {
        return;
    }

    const geocoder = new google.maps.Geocoder();
    const searchInput = zipCode.trim();

    geocoder.geocode({
        address: searchInput,
        componentRestrictions: { country: 'US'}
    }, (results, status) => {
        if (status === 'OK' && results[0]) {
            const location = results[0].geometry.location;

            window.MountainlandApp.userLocation = {
                lat: location.lat(),
                lng: location.lng()
            };

            if (window.MountainlandApp.map) {
                window.MountainlandApp.map.setCenter(window.MountainlandApp.userLocation);
                window.MountainlandApp.map.setZoom(10);
            }

            window.MountainlandApp.hasUserInteracted = true;
            window.mapsLoader.applyFilters();

        } else {
            alert(`Unable to find location for "${searchInput}". Please try:\n- A ZIP code (e.g., "84101")\n- A city and state (e.g., "Salt Lake City, UT")\n- Just a city name (e.g., "Denver")`);
        }
    });
}

function reverseGeocode(lat, lng) {
    if (!window.google || !window.google.maps) return;

    const geocoder = new google.maps.Geocoder();
    const latlng = { lat: lat, lng: lng };

    geocoder.geocode({ location: latlng }, (results, status) => {
        if (status === 'OK' && results[0]) {
            const postalCode = results[0].address_components.find(
                component => component.types.includes('postal_code')
            );

            if (postalCode) {
                document.getElementById('zip-input').value = postalCode.long_name;
            } else {
                document.getElementById('zip-input').value = results[0].formatted_address;
            }
        }
    });
}

function setupFilters() {
    const searchBtn = document.getElementById('search-now-btn');
    const resetBtn = document.getElementById('reset-filters-btn');
    const locationBtn = document.getElementById('location-btn');
    const radiusSelect = document.getElementById('radius-select');
    const zipInput = document.getElementById('zip-input');

    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            window.MountainlandApp.hasUserInteracted = true;
            const zipCode = zipInput?.value.trim();
            if (zipCode && !window.MountainlandApp.userLocation && !window.mapsLoader.userLocation) {
                geocodeZipCode(zipCode);
            } else {
                window.mapsLoader.applyFilters();
            }
        });
    }

    if (zipInput) {
        zipInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const zipCode = zipInput.value.trim();
                if (zipCode) {
                    geocodeZipCode(zipCode);
                }
            }
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', resetFilters);
    }

    if (locationBtn) {
        const host = window.location.hostname;
        const isLocalDevHost = host === 'localhost' || host === '127.0.0.1' || host === '::1' || host.endsWith('.localhost');
        const isSecure = (window.isSecureContext === true) || (window.location.protocol === 'https:') || isLocalDevHost;
        const geoAvailable = 'geolocation' in navigator;

        console.debug('[Geo] host=%s, protocol=%s, isSecureContext=%s, isLocalDevHost=%s, computedIsSecure=%s, geoAvailable=%s', host, window.location.protocol, window.isSecureContext, isLocalDevHost, isSecure, geoAvailable);

        if (isSecure && geoAvailable) {
            locationBtn.addEventListener('click', useCurrentLocation);
        } else {
            locationBtn.disabled = true;
            locationBtn.style.opacity = '0.6';
            locationBtn.style.cursor = 'not-allowed';
            locationBtn.title = 'Use Current Location requires HTTPS (or localhost).';
        }
    }

    if (radiusSelect) {
        radiusSelect.addEventListener('change', () => {
            if (window.MountainlandApp.userLocation) {
                window.MountainlandApp.hasUserInteracted = true;
                window.mapsLoader.applyFilters();
            }
        });
    }
}

function resetFilters() {
    document.querySelectorAll('input[name="branch-type"]').forEach(cb => {
        cb.checked = false;
    });
    
    const zipInput = document.getElementById('zip-input');
    const radiusSelect = document.getElementById('radius-select');
    const searchInput = document.getElementById('search-input');
    
    if (zipInput) zipInput.value = '';
    if (radiusSelect) radiusSelect.value = '25';
    if (searchInput) searchInput.value = '';
    
    window.MountainlandApp.userLocation = null;
    window.MountainlandApp.hasUserInteracted = false;
    
    window.MountainlandApp.filteredLocations = [...window.MountainlandApp.locations];
    
    if (window.mapsLoader && window.mapsLoader.isLoaded) {
        window.mapsLoader.addMarkersToMap(window.MountainlandApp.locations);
        window.mapsLoader.populateLocationList(window.MountainlandApp.locations);
        setTimeout(() => setupPhonePanels(), 50);
        window.mapsLoader.updateURLParams();
        
        if (window.MountainlandApp.map && window.MountainlandApp.locations.length > 0) {
            const bounds = new google.maps.LatLngBounds();
            window.MountainlandApp.locations.forEach(loc => {
                const coords = window.mapsLoader.getValidCoordinates(loc);
                if (coords) bounds.extend(coords);
            });
            window.MountainlandApp.map.fitBounds(bounds);
        }
    }
}

function useCurrentLocation() {
    const host = window.location.hostname;
    const isLocalDevHost = host === 'localhost' || host === '127.0.0.1' || host === '::1' || host.endsWith('.localhost');
    const isSecure = (window.isSecureContext === true) || (window.location.protocol === 'https:') || isLocalDevHost;

    if (!isSecure) {
        alert('Use Current Location requires a secure context. Please access the site via HTTPS or localhost.');
        return;
    }

    if (navigator.geolocation) {
        try {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;

                    window.MountainlandApp.userLocation = {
                        lat: latitude,
                        lng: longitude
                    };
                    
                    if (window.mapsLoader) {
                        window.mapsLoader.userLocation = { lat: latitude, lng: longitude };
                    }

                    if (window.MountainlandApp.map) {
                        window.MountainlandApp.map.setCenter({
                            lat: latitude,
                            lng: longitude
                        });
                        window.MountainlandApp.map.setZoom(10);

                        new google.maps.Marker({
                            position: { lat: latitude, lng: longitude },
                            map: window.MountainlandApp.map,
                            title: "Your Location",
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 8,
                                fillColor: '#4285F4',
                                fillOpacity: 1,
                                strokeColor: '#ffffff',
                                strokeWeight: 2
                            }
                        });
                    }

                    window.MountainlandApp.hasUserInteracted = true;
                },
                (error) => {
                    const msg = (error && error.message) ? error.message : 'Could not get your location.';
                    if (/secure context/i.test(msg)) {
                        alert('Use Current Location requires HTTPS (or localhost). Please switch to https:// or enter a ZIP code.');
                    } else {
                        alert(`${msg}\n\nTip: Enter a ZIP code or city/state to search manually.`);
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 300000
                }
            );
        } catch (e) {
            alert('Use Current Location requires HTTPS (or localhost). Please switch to https:// or enter a ZIP code.');
        }
    } else {
        alert('Geolocation is not supported by this browser. Please enter your zip code manually.');
    }
}

function performLocationSearch(query) {
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.value = query;
    }
    window.mapsLoader.applyFilters();
}

let phonePanelsInitialized = false;

function setupPhonePanels() {
    if (phonePanelsInitialized) {
        return;
    }
    phonePanelsInitialized = true;
    
    console.log('Setting up phone panels...');
    
    document.addEventListener('click', function(e) {
        const phonePanels = document.querySelectorAll('.phone-panel.active');
        phonePanels.forEach(panel => {
            if (!panel.contains(e.target) && !e.target.closest('.call-btn')) {
                panel.classList.remove('active');
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.call-btn')) {
            const callBtn = e.target.closest('.call-btn');
            let nextElement = callBtn.nextElementSibling;
            let phonePanel = null;
            
            while (nextElement) {
                if (nextElement.classList.contains('phone-panel')) {
                    phonePanel = nextElement;
                    break;
                }
                nextElement = nextElement.nextElementSibling;
            }
            
            if (phonePanel) {
                const allPanels = document.querySelectorAll('.phone-panel.active');
                allPanels.forEach(panel => {
                    if (panel !== phonePanel) {
                        panel.classList.remove('active');
                    }
                });
                
                phonePanel.classList.toggle('active');
                e.stopPropagation();
            }
        }

        if (e.target.closest('.phone-panel-close')) {
            const closeBtn = e.target.closest('.phone-panel-close');
            const phonePanel = closeBtn.closest('.phone-panel');
            if (phonePanel) {
                phonePanel.classList.remove('active');
                e.stopPropagation();
            }
        }

        if (e.target.closest('.main-store-btn')) {
            const btn = e.target.closest('.main-store-btn');
            const branchId = btn.dataset.branchId;
            if (branchId) {
                setMainStore(branchId);
                e.stopPropagation();
            }
        }
    });
}

function setMainStore(branchId) {
    const numericBranchId = parseInt(branchId, 10);
    
    if (isNaN(numericBranchId)) {
        alert('Error: Invalid location ID. Please try again.');
        return;
    }
    
    fetch('/carts/ship-branch', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ branchId: numericBranchId })
    })
        .then(async response => {
            const responseText = await response.text();
            
            if (!response.ok) {
                let errorData;
                try {
                    errorData = JSON.parse(responseText);
                } catch (e) {
                    errorData = responseText;
                }
                throw new Error(`HTTP error! status: ${response.status} - ${JSON.stringify(errorData)}`);
            }
            
            return JSON.parse(responseText);
        })
        .then(data => {
            if (typeof window.updateShoppingLocation === 'function') {
                window.updateShoppingLocation();
            }
        })
        .catch(error => {
            alert('Unable to set main store. Please try again or contact support if the problem persists.');
        });
}

function copyPhoneNumber(phoneNumber) {
    navigator.clipboard.writeText(phoneNumber).then(() => {
        alert('Phone number copied to clipboard: ' + phoneNumber);
    }).catch(err => {
        // Silently fail if copy not available
    });
}

window.DEV_TEST_DATE = null;
function setTestDate(month, day) {
    if (month === null || month === undefined) {
        window.DEV_TEST_DATE = null;
        if (window.mapsLoader && window.MountainlandApp.filteredLocations) {
            window.mapsLoader.populateLocationList(window.MountainlandApp.filteredLocations);
        }
        return;
    }
    if (month < 1 || month > 12 || day < 1 || day > 31) {
        return;
    }
    window.DEV_TEST_DATE = { month, day };
    if (window.mapsLoader && window.MountainlandApp.filteredLocations) {
        window.mapsLoader.populateLocationList(window.MountainlandApp.filteredLocations);
    }
}

function getCurrentSeason(hours) {
    if (!hours || !hours.seasonal || !hours.seasons || !Array.isArray(hours.seasons)) {
        return null;
    }
    
    const now = window.DEV_TEST_DATE 
        ? new Date(2024, window.DEV_TEST_DATE.month - 1, window.DEV_TEST_DATE.day)
        : new Date();
    const currentMonth = now.getMonth() + 1;
    const currentDay = now.getDate();
    
    for (const season of hours.seasons) {
        if (!season.start || !season.end) continue;
        
        const [startMonth, startDay] = season.start.split('-').map(Number);
        const [endMonth, endDay] = season.end.split('-').map(Number);
        
        let isInSeason = false;
        
        if (startMonth <= endMonth) {
            if (currentMonth > startMonth && currentMonth < endMonth) {
                isInSeason = true;
            } else if (currentMonth === startMonth && currentDay >= startDay) {
                isInSeason = true;
            } else if (currentMonth === endMonth && currentDay <= endDay) {
                isInSeason = true;
            }
        } else {
            if (currentMonth > startMonth || currentMonth < endMonth) {
                isInSeason = true;
            } else if (currentMonth === startMonth && currentDay >= startDay) {
                isInSeason = true;
            } else if (currentMonth === endMonth && currentDay <= endDay) {
                isInSeason = true;
            }
        }
        
        if (isInSeason) {
            return {
                name: season.name,
                schedule: season.schedule
            };
        }
    }
    
    return hours.seasons.length > 0 ? {
        name: hours.seasons[0].name,
        schedule: hours.seasons[0].schedule
    } : null;
}

function formatHours(hours) {
    if (!hours) return '';
    if (typeof hours === 'string') return hours;
    if (typeof hours === 'object') {
        if (hours.seasonal && hours.seasons) {
            const currentSeason = getCurrentSeason(hours);
            if (currentSeason && currentSeason.schedule) {
                const schedule = currentSeason.schedule;
                const daysOrder = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                const label = {
                    monday: 'Mon', tuesday: 'Tue', wednesday: 'Wed', thursday: 'Thu',
                    friday: 'Fri', saturday: 'Sat', sunday: 'Sun'
                };
                const parts = [];
                for (const d of daysOrder) {
                    if (Object.prototype.hasOwnProperty.call(schedule, d) && schedule[d]) {
                        parts.push(`${label[d]}: ${schedule[d]}`);
                    }
                }
                return `${currentSeason.name} - ${parts.join(' | ')}`;
            }
        }
        const daysOrder = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        const label = {
            monday: 'Mon', tuesday: 'Tue', wednesday: 'Wed', thursday: 'Thu',
            friday: 'Fri', saturday: 'Sat', sunday: 'Sun'
        };
        const parts = [];
        for (const d of daysOrder) {
            if (Object.prototype.hasOwnProperty.call(hours, d) && hours[d]) {
                parts.push(`${label[d]}: ${hours[d]}`);
            }
        }
        return parts.join(' | ');
    }
    return '';
}

function formatAddress(address) {
    if (!address) return 'Address not available';
    if (typeof address === 'string') return address;
    const parts = [];
    const line1 = address.line1 || '';
    const city = address.city || '';
    const state = address.state || '';
    if (line1) parts.push(line1);
    const cityState = [city, state].filter(Boolean).join(', ');
    if (cityState) parts.push(cityState);
    return parts.join(', ') || 'Address not available';
}

window.setTestTime = function(hour, minute) {
    if (hour === null || hour === undefined) {
        delete window.DEV_TEST_TIME;
        if (window.mapsLoader && window.MountainlandApp.filteredLocations) {
            window.mapsLoader.populateLocationList(window.MountainlandApp.filteredLocations);
        }
        return;
    }
    
    if (typeof hour !== 'number' || hour < 0 || hour > 23) {
        return;
    }
    if (typeof minute !== 'number' || minute < 0 || minute > 59) {
        return;
    }
    
    window.DEV_TEST_TIME = { hour, minute };
    
    if (window.mapsLoader && window.MountainlandApp.filteredLocations) {
        window.mapsLoader.populateLocationList(window.MountainlandApp.filteredLocations);
    }
};

function isLocationOpen(hours) {
    if (!hours) return null;
    
    const now = new Date();
    let currentHour, currentMinute;
    
    if (window.DEV_TEST_TIME) {
        currentHour = window.DEV_TEST_TIME.hour;
        currentMinute = window.DEV_TEST_TIME.minute;
    } else {
        currentHour = now.getHours();
        currentMinute = now.getMinutes();
    }
    
    const currentDay = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'][now.getDay()];
    
    if (typeof hours === 'string') return null;
    
    let scheduleToCheck = hours;
    if (hours.seasonal && hours.seasons) {
        const currentSeason = getCurrentSeason(hours);
        if (currentSeason && currentSeason.schedule) {
            scheduleToCheck = currentSeason.schedule;
        } else {
            return null;
        }
    }
    
    const todayHours = scheduleToCheck[currentDay];
    if (!todayHours) return null;
    
    if (todayHours.toLowerCase().includes('closed')) {
        return { isOpen: false, nextChange: 'Closed today' };
    }
    
    const timePattern = /(\d{1,2}):?(\d{2})?\s*(AM|PM)?/gi;
    const matches = [...todayHours.matchAll(timePattern)];
    
    if (matches.length < 2) return null;
    
    const openHour = parseInt(matches[0][1]);
    const openMinute = parseInt(matches[0][2] || '0');
    const openPeriod = matches[0][3] || '';
    let openHour24 = openHour;
    if (openPeriod.toUpperCase() === 'PM' && openHour !== 12) openHour24 += 12;
    if (openPeriod.toUpperCase() === 'AM' && openHour === 12) openHour24 = 0;
    
    const closeHour = parseInt(matches[1][1]);
    const closeMinute = parseInt(matches[1][2] || '0');
    const closePeriod = matches[1][3] || '';
    let closeHour24 = closeHour;
    if (closePeriod.toUpperCase() === 'PM' && closeHour !== 12) closeHour24 += 12;
    if (closePeriod.toUpperCase() === 'AM' && closeHour === 12) closeHour24 = 0;
    
    const currentMinutes = currentHour * 60 + currentMinute;
    const openMinutes = openHour24 * 60 + openMinute;
    const closeMinutes = closeHour24 * 60 + closeMinute;
    
    const isOpen = currentMinutes >= openMinutes && currentMinutes < closeMinutes;
    
    let nextChange = '';
    if (isOpen) {
        const closeTime12 = closeHour === 12 ? 12 : closeHour > 12 ? closeHour - 12 : closeHour;
        const closePeriodLabel = closeHour24 >= 12 ? 'PM' : 'AM';
        nextChange = `Closes at ${closeTime12}:${closeMinute.toString().padStart(2, '0')} ${closePeriodLabel}`;
    } else {
        const openTime12 = openHour === 12 ? 12 : openHour > 12 ? openHour - 12 : openHour;
        const openPeriodLabel = openHour24 >= 12 ? 'PM' : 'AM';
        nextChange = `Opens at ${openTime12}:${openMinute.toString().padStart(2, '0')} ${openPeriodLabel}`;
    }
    
    return { isOpen, nextChange };
}

function renderHoursTable(hours, phoneHtml = '') {
    if (!hours) return '';
    
    if (typeof hours === 'string') {
        return `
            <div class="location-hours">
                <div class="hours-header">Hours</div>
                <div class="hours-row"><span class="hours-time">${hours}</span></div>
                ${phoneHtml ? `<div class="location-phones">${phoneHtml}</div>` : ''}
            </div>
        `;
    }
    
    let scheduleToDisplay = hours;
    let seasonalLabel = '';
    
    if (hours.seasonal && hours.seasons) {
        const currentSeason = getCurrentSeason(hours);
        if (currentSeason && currentSeason.schedule) {
            scheduleToDisplay = currentSeason.schedule;
            seasonalLabel = `<span style="font-size: 0.8rem; color: #888; font-style: italic; margin-left: 0.5rem; font-weight: 400;">(${currentSeason.name})</span>`;
        }
    }
    
    const days = [
        ['monday','Mon'], ['tuesday','Tue'], ['wednesday','Wed'],
        ['thursday','Thu'], ['friday','Fri'], ['saturday','Sat'], ['sunday','Sun']
    ];
    const rows = days
        .map(([key, label]) => {
            const val = scheduleToDisplay && scheduleToDisplay[key];
            if (!val) return null;
            return `<div class="hours-row"><span class="hours-day">${label}:</span><span class="hours-time">${val}</span></div>`;
        })
        .filter(Boolean)
        .join('');
    if (!rows) return '';
    return `
        <div class="location-hours">
            <div class="hours-header">Hours${seasonalLabel}</div>
            ${rows}
            ${phoneHtml ? `<div class="location-phones">${phoneHtml}</div>` : ''}
        </div>
    `;
}

function setupSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const toggleBtn = document.getElementById("sidebar-toggle");
    let overlay = document.getElementById("sidebar-overlay");
    const body = document.body;

    if (!toggleBtn || !sidebar) {
        return;
    }

    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'sidebar-overlay';
        document.body.appendChild(overlay);
    }

    const newButton = toggleBtn.cloneNode(true);
    toggleBtn.parentNode.replaceChild(newButton, toggleBtn);

    function toggleSidebar(show = null) {
        const isOpen = show !== null ? show : !sidebar.classList.contains("active");
        
        if (isOpen) {
            sidebar.classList.add("active");
            overlay.classList.add("active");
            body.classList.add("sidebar-open");
            newButton.textContent = "◄";
            
            if (window.innerWidth <= 1024) {
                body.style.overflow = "hidden";
            }
        } else {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
            body.classList.remove("sidebar-open");
            newButton.textContent = "►";
            body.style.overflow = "";
        }
    }

    newButton.addEventListener("click", (e) => {
        e.stopPropagation();
        e.preventDefault();
        toggleSidebar();
    });

    overlay.addEventListener("click", () => {
        toggleSidebar(false);
    });

    document.addEventListener("click", (e) => {
        if (window.innerWidth <= 1024 && 
            sidebar.classList.contains("active") && 
            !sidebar.contains(e.target) && 
            !newButton.contains(e.target)) {
            toggleSidebar(false);
        }
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && sidebar.classList.contains("active")) {
            toggleSidebar(false);
        }
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth > 1024) {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
            body.classList.remove("sidebar-open");
            body.style.overflow = "";
        }
    });

    const searchBtn = document.getElementById('search-now-btn');
    const resetBtn = document.getElementById('reset-filters-btn');
    
    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            if (window.innerWidth <= 1024) {
                setTimeout(() => toggleSidebar(false), 500);
            }
        });
    }
    
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (window.innerWidth <= 1024) {
                setTimeout(() => toggleSidebar(false), 500);
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', async function() {
    const mapWrapper = document.getElementById('map-wrapper');
    if (!mapWrapper) {
        return;
    }

    try {
        setupSidebar();
        setupFilters();
        
        window.mapsLoader = new LocationsMap();
        await window.mapsLoader.init();
    } catch (error) {
    }
});

window.geocodeZipCode = geocodeZipCode;
window.reverseGeocode = reverseGeocode;
window.setupFilters = setupFilters;
window.resetFilters = resetFilters;
window.useCurrentLocation = useCurrentLocation;
window.performLocationSearch = performLocationSearch;
window.setupPhonePanels = setupPhonePanels;
window.copyPhoneNumber = copyPhoneNumber;
window.setTestDate = setTestDate;
window.getCurrentSeason = getCurrentSeason;
window.formatHours = formatHours;
window.formatAddress = formatAddress;
window.isLocationOpen = isLocationOpen;
window.renderHoursTable = renderHoursTable;
window.setupSidebar = setupSidebar;

})();
