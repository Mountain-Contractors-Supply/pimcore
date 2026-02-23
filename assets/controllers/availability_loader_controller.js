import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["availability"]

    connect() {
        this.fetchAvailability();
    }

    fetchAvailability() {
        const allIds = this.availabilityTargets.map(el => el.dataset.id);
        const uniqueIds = [...new Set(allIds)];

        if (uniqueIds.length === 0) return;

        fetch('/availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ productIds: uniqueIds })
        })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                this.updateAllInstances(data);
            })
            .catch(error => {
                console.error('Error fetching availability:', error);
            });
    }

    updateAllInstances(data) {
        Object.entries(data).forEach(([id, availability]) => {
            if (availability !== 'Loading...') {
                const elements = document.querySelectorAll(`.availability-target-${id}`);

                elements.forEach(el => {
                    this.applyPriceEffect(el, availability);
                });
            }
        });
    }

    applyPriceEffect(element, availability) {
        element.innerText = availability;
        element.classList.add('availability-loaded');
    }
}
