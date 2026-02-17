import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["placeholder"]

    connect() {
        this.fetchPrices();
    }

    fetchPrices() {
        const allIds = this.placeholderTargets.map(el => el.dataset.id);
        const uniqueIds = [...new Set(allIds)];

        if (uniqueIds.length === 0) return;

        fetch('/price', {
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
                console.error('Error fetching prices:', error);
            });
    }

    updateAllInstances(data) {
        Object.entries(data).forEach(([id, price]) => {
            if (price !== 'Loading...') {
                const elements = document.querySelectorAll(`.price-target-${id}`);

                elements.forEach(el => {
                    this.applyPriceEffect(el, price);
                });
            }
        });
    }

    applyPriceEffect(element, price) {
        element.innerText = price;
        element.classList.add('price-loaded');
    }
}
