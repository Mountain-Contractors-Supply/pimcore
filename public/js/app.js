const MountainlandApp = (function() {
    const state = {
        map: null,
        locations: [],
        config: null,
        filteredLocations: [],
        markers: [],
        infoWindows: [],
        currentInfoWindow: null,
        userLocation: null,
        hasUserInteracted: false
    };
    
    function haversineFormula(lat1, lng1, lat2, lng2) {
        lat1 = parseFloat(lat1);
        lng1 = parseFloat(lng1);
        lat2 = parseFloat(lat2);
        lng2 = parseFloat(lng2);
        
        if (isNaN(lat1) || isNaN(lng1) || isNaN(lat2) || isNaN(lng2)) {
            console.error('Invalid coordinates provided to function "haversineFormula"');
            return Infinity;
        }
        
        const R = 6371000;
        const toRad = (x) => (x * Math.PI) / 180;
        
        const dLat = toRad(lat2 - lat1);
        const dLng = toRad(lng2 - lng1);
        
        const a = Math.sin(dLat / 2) ** 2 +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * 
                Math.sin(dLng / 2) ** 2;
        
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        
        return R * c;
    }

    return {
        get map() { return state.map; },
        set map(value) { state.map = value; },
        get locations() { return state.locations; },
        set locations(value) { state.locations = value; },
        get config() { return state.config; },
        set config(value) { state.config = value; },
        get filteredLocations() { return state.filteredLocations; },
        set filteredLocations(value) { state.filteredLocations = value; },
        get markers() { return state.markers; },
        set markers(value) { state.markers = value; },
        get infoWindows() { return state.infoWindows; },
        set infoWindows(value) { state.infoWindows = value; },
        get currentInfoWindow() { return state.currentInfoWindow; },
        set currentInfoWindow(value) { state.currentInfoWindow = value; },
        get userLocation() { return state.userLocation; },
        set userLocation(value) { state.userLocation = value; },
        get hasUserInteracted() { return state.hasUserInteracted; },
        set hasUserInteracted(value) { state.hasUserInteracted = value; },
        
        state,
        haversineFormula,
        
        init() {
            window.MountainlandApp = this;
            console.log("Mountainland App initialized");
            
            if (typeof window.haversineFormula !== 'function') {
                window.haversineFormula = this.haversineFormula;
            }
        }
    };
})();

MountainlandApp.init();
window.MountainlandApp.focusLocation = function(locationId) {
    const location = this.filteredLocations.find(loc => (loc.id || loc.name || loc.title) === locationId);
    if (location && this.map) {
        const coords = window.mapsLoader.getValidCoordinates(location);
        if (coords) {
            this.map.setCenter(coords);
            this.map.setZoom(15);

            const markerIndex = this.filteredLocations.findIndex(loc => (loc.id || loc.name || loc.title) === locationId);
            if (markerIndex >= 0 && this.markers[markerIndex]) {
                google.maps.event.trigger(this.markers[markerIndex], 'click');
            }
        }
    }
};

function setupHeaderSearch() {
    const searchBox = document.getElementById('search-box');

    if (searchBox) {
        searchBox.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const query = searchBox.value;
                if (typeof window.performLocationSearch === 'function') {
                    window.performLocationSearch(query);
                } else {
                    window.location.href = `/locations?search=${encodeURIComponent(query)}`;
                }
            }
        });

        const searchIcon = document.querySelector('#header-search img');
        if (searchIcon) {
            searchIcon.style.cursor = 'pointer';
            searchIcon.addEventListener('click', () => {
                const query = searchBox.value;
                if (typeof window.performLocationSearch === 'function') {
                    window.performLocationSearch(query);
                } else {
                    window.location.href = `/locations?search=${encodeURIComponent(query)}`;
                }
            });
        }
    }
}


function setupScrollAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                console.log('✅ Element is now visible, adding fade-in class');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    const mapImage = document.querySelector('.layout-wrapper:last-of-type .sidebar img[alt="Locations Map"]');
    
    if (mapImage) {
        const sidebarContainer = mapImage.closest('.sidebar');
        if (sidebarContainer) {
            sidebarContainer.classList.add('map-sidebar');
            observer.observe(sidebarContainer);
            console.log('✅ Scroll animation set up for map image sidebar');
        }
    } else {
        console.warn('⚠️ Map image not found - make sure the image exists');
    }
}

function updateShipBranchUi(data) {
    const branchStatus = document.getElementById('branch-status');
    if (!branchStatus) return;

    if (data && data.name) {
        branchStatus.innerHTML = `You're shopping at<br><strong>${data.name}</strong>`;
    } else if (data.branchId) {
        branchStatus.textContent = `Branch ID: ${data.branchId}`;
    } else {
        branchStatus.textContent = 'You do not currently have a branch selected';
    }
}

function getShipBranch() {
    const branchStatus = document.getElementById('branch-status');
    if (!branchStatus) return;

    fetch('/carts/ship-branch', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            updateShipBranchUi(data);
        })
        .catch(error => {
            console.error('Error fetching ship branch:', error);
            branchStatus.textContent = 'You do not currently have a branch selected';
        });
}

function setShipBranch(branchId) {
    return fetch('/carts/ship-branch', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ branchId: branchId })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            updateShipBranchUi(data);
            return data;
        })
        .catch(error => {
            console.error('Error setting ship branch:', error);
            throw error;
        });
}

function updateBagTotal() {
    const bagTotalElement = document.getElementById('bag-total');
    const bagCountElement = document.getElementById('bag-count');
    if (!bagTotalElement) return;

    fetch('/carts')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const subTotal = data.subTotal !== undefined ? parseFloat(data.subTotal) : 0;
            bagTotalElement.textContent = `$${subTotal.toFixed(2)}`;
            
            if (bagCountElement) {
                let count = 0;
                const items = data.items || [];
                
                if (Array.isArray(items)) {
                    items.forEach(item => {
                        const qty = item?.quantityOrdered?.quantity;
                        if (qty !== undefined) {
                            count += parseInt(qty, 10);
                        }
                    });
                } else if (typeof items === 'object') {
                    Object.values(items).forEach(item => {
                        const qty = item?.quantityOrdered?.quantity;
                        if (qty !== undefined) {
                            count += parseInt(qty, 10);
                        }
                    });
                }
                
                bagCountElement.textContent = count === 1 ? '1 item' : `${count} items`;
            }
        })
        .catch(error => {
            console.error('Error fetching cart:', error);
        });
}

window.updateShoppingLocation = getShipBranch;
window.getShipBranch = getShipBranch;
window.setShipBranch = setShipBranch;
window.updateBagTotal = updateBagTotal;

document.addEventListener('DOMContentLoaded', () => {
    setupHeaderSearch();
    setupScrollAnimations();
    getShipBranch();
    updateBagTotal();

    const userInfo = document.getElementById('user-info');
    const dropdownMenu = document.getElementById('dropdown-menu');
    
    if (userInfo && dropdownMenu) {
        userInfo.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.user-dropdown')) {
                dropdownMenu.classList.remove('show');
            }
        });
    }

    const branchInfo = document.getElementById('branch-info');
    if (branchInfo) {
        branchInfo.addEventListener('click', () => {
            window.location.href = '/locations';
        });
    }

    document.addEventListener('cartUpdated', () => {
        updateBagTotal();
    });
});
