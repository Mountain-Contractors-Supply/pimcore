import { Controller } from '@hotwired/stimulus';
import * as Turbo from '@hotwired/turbo';

export default class extends Controller {
    static targets = ["incart"]

    disconnect() {
        clearTimeout(this.fetchTimeout);
    }

    incartTargetConnected() {
        const allIds = this.incartTargets.map(el => el.dataset.id);
        const uniqueIds = [...new Set(allIds)];

        if (uniqueIds.length === 0) return;

        // Debounce to avoid multiple rapid calls
        clearTimeout(this.fetchTimeout);
        this.fetchTimeout = setTimeout(async () => {
            const response = await fetch('/cart/incart', {
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