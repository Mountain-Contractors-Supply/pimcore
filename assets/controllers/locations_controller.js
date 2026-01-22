import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.mapElement = this.element.querySelector('[data-controller~="symfony--ux-google-map--map"]');

        if (!this.mapElement) {
            console.warn('[locations] could not find ux_map element under wrapper');
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

            // Classic Marker
            if (typeof marker.addListener === 'function') {
                marker.addListener('click', handler);

                // Advanced Marker uses this event name
                marker.addListener('gmp-click', handler);
                return;
            }

            // As a fallback, some objects expose DOM events
            if (typeof marker.addEventListener === 'function') {
                marker.addEventListener('gmp-click', handler);
                marker.addEventListener('click', handler);
            }
        };

        this.mapElement.addEventListener('ux:map:connect', this.onMapConnect);
        this.mapElement.addEventListener('ux:map:marker:after-create', this.onMarkerAfterCreate);
    }

    disconnect() {
        if (this.mapElement) {
            this.mapElement.removeEventListener('ux:map:connect', this.onMapConnect);
            this.mapElement.removeEventListener('ux:map:marker:after-create', this.onMarkerAfterCreate);
        }
    }

    centerOnGoogleMarker(marker) {
        const map = this.map;
        if (!map) return;

        // Extract position for both marker types
        const position =
            (typeof marker.getPosition === 'function' && marker.getPosition())
            || marker.position;

        if (!position) {
            console.warn('[locations] could not determine marker position', marker);
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

        console.warn('[locations] map does not look like google.maps.Map', map);
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
                // Silently fail if copy not available / permission denied
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