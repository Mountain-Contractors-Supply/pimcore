import { Controller } from '@hotwired/stimulus';
import * as Turbo from '@hotwired/turbo';

export default class extends Controller {
    static targets = ["price"]

    disconnect() {
        clearTimeout(this.fetchTimeout);
    }

    priceTargetConnected() {
        const allIds = this.priceTargets.map(el => el.dataset.id);
        const uniqueIds = [...new Set(allIds)];

        if (uniqueIds.length === 0) return;

        // Debounce to avoid multiple rapid calls
        clearTimeout(this.fetchTimeout);
        this.fetchTimeout = setTimeout(async () => {
            const response = await fetch('/price', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'text/vnd.turbo-stream.html'
                },
                body: JSON.stringify({ productIds: uniqueIds })
            });

            if (response.ok) {
                const html = await response.text();

                if (html) {
                    Turbo.renderStreamMessage(html);
                }
            }
        }, 50);
    }
}