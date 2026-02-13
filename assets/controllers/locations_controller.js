import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
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