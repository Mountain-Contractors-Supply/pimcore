import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["price"]

    connect() {
        this.fetchPrices();
    }

    fetchPrices() {
        const allIds = this.priceTargets.map(el => el.dataset.id);
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
            })
    }
}
