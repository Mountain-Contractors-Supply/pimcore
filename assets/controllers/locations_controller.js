import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['zipInput', 'radiusSelect', 'locationBtn', 'sidebarToggle', 'sidebarOverlay', 'filterContainer'];
    static values = {
        currentLocation: Object,
    };

    connect() {
        this.mapElement = this.element.querySelector('[data-controller~="symfony--ux-google-map--map"]');

        if (!this.mapElement) {
            return;
        }

        this.map = null;
        this.onMapConnect = (event) => {
            this.map = event.detail.map;
        };

        this.onMarkerAfterCreate = (event) => {
            const marker = event.detail.marker;
            if (!marker) return;

            const handler = () => this.centerOnGoogleMarker(marker);

            if (typeof marker.addListener === 'function') {
                marker.addListener('click', handler);
                marker.addListener('gmp-click', handler);
                return;
            }

            if (typeof marker.addEventListener === 'function') {
                marker.addEventListener('gmp-click', handler);
                marker.addEventListener('click', handler);
            }
        };

        this.mapElement.addEventListener('ux:map:connect', this.onMapConnect);
        this.mapElement.addEventListener('ux:map:marker:after-create', this.onMarkerAfterCreate);

        // LAST Stack: Attach event listeners for geolocation and sidebar
        this.attachEventListeners();
    }

    disconnect() {
        if (this.mapElement) {
            this.mapElement.removeEventListener('ux:map:connect', this.onMapConnect);
            this.mapElement.removeEventListener('ux:map:marker:after-create', this.onMarkerAfterCreate);
        }
    }

    // LAST Stack: Event listeners for Stimulus interactions
    attachEventListeners() {
        // Geolocation button
        if (this.hasLocationBtnTarget) {
            this.locationBtnTarget.addEventListener('click', (e) => this.handleGeolocation(e));
        }

        // Sidebar toggle for mobile
        if (this.hasSidebarToggleTarget) {
            this.sidebarToggleTarget.addEventListener('click', (e) => this.toggleSidebar(e));
        }

        // Close sidebar when overlay is clicked
        if (this.hasSidebarOverlayTarget) {
            this.sidebarOverlayTarget.addEventListener('click', (e) => this.closeSidebar(e));
        }

        // Enter key on zip input to apply filters
        if (this.hasZipInputTarget) {
            this.zipInputTarget.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.applyFiltersAction();
                }
            });
        }
    }

    handleGeolocation(event) {
        event.preventDefault();

        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const { latitude, longitude } = position.coords;
                this.currentLocationValue = { lat: latitude, lng: longitude };

                // Update UI with coordinates
                if (this.hasZipInputTarget) {
                    this.zipInputTarget.value = `${latitude.toFixed(4)}, ${longitude.toFixed(4)}`;
                }

                // Trigger live component update
                this.applyFiltersAction();
            },
            (error) => {
                console.error('Geolocation error:', error);
                alert('Unable to get your location. Please check your browser permissions.');
            }
        );
    }

    applyFiltersAction() {
        // Get the live component element and dispatch event
        const liveComponent = this.element.closest('[data-live-component]');
        if (liveComponent) {
            liveComponent.dispatchEvent(new CustomEvent('live:action-invoke', {
                detail: { action: 'applyFilters' },
                bubbles: true,
            }));
        }
    }

    toggleSidebar(event) {
        event.preventDefault();
        if (this.hasFilterContainerTarget) {
            this.filterContainerTarget.classList.toggle('hidden');
        }
        if (this.hasSidebarOverlayTarget) {
            this.sidebarOverlayTarget.classList.toggle('hidden');
        }
    }

    closeSidebar(event) {
        event.preventDefault();
        if (this.hasFilterContainerTarget) {
            this.filterContainerTarget.classList.add('hidden');
        }
        if (this.hasSidebarOverlayTarget) {
            this.sidebarOverlayTarget.classList.add('hidden');
        }
    }

    centerOnGoogleMarker(marker) {
        const map = this.map;
        if (!map) return;

        const position =
            (typeof marker.getPosition === 'function' && marker.getPosition())
            || marker.position;

        if (!position) {
            return;
        }

        if (typeof map.panTo === 'function') {
            map.panTo(position);
            return;
        }

        if (typeof map.setCenter === 'function') {
            map.setCenter(position);
            return;
        }
    }

    copy(event) {
        const button = event.currentTarget;
        const phoneNumber = button.dataset.phoneNumber || '';

        if (!phoneNumber) return;

        if (!navigator.clipboard || !navigator.clipboard.writeText) {
            return;
        }

        navigator.clipboard.writeText(phoneNumber)
            .then(() => {
                alert('Phone number copied to clipboard: ' + phoneNumber);
            })
            .catch(() => {
            });
    }

    async setMainStore(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const branchIdRaw = button.dataset.branchId || '';
        const numericBranchId = parseInt(branchIdRaw, 10);

        if (Number.isNaN(numericBranchId)) {
            alert('Error: Invalid location ID. Please try again.');
            return;
        }

        try {
            await fetch('/carts/ship-branch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ branchId: numericBranchId }),
            });
        } catch (error) {
            alert('Unable to set main store. Please try again or contact support if the problem persists.');
        }
    }
}