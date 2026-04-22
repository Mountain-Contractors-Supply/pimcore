import { Controller } from "@hotwired/stimulus";
import * as Turbo from "@hotwired/turbo";

export default class extends Controller {
    static targets = ["qtyInput"];
    static values = {
        productId: String,
        uom: String,
        minQuantity: { type: Number, default: 1 }
    };

    async onNumericInputChanged(event) {
        const newQty = parseInt(this.qtyInputTarget.value, 10) || this.minQuantityValue;
        await this.updateQuantity(newQty);
    }

    async add() {
        const quantity = Math.max(this.minQuantityValue, parseInt(this.qtyInputTarget?.value, 10) || this.minQuantityValue);
        await this.adjustCart('POST', quantity);

        if (this.qtyInputTarget) {
            this.qtyInputTarget.value = String(this.minQuantityValue);
        }
    }

    async updateQuantity(quantity) {
        await this.adjustCart('PUT', quantity);
    }

    async remove() {
        await this.adjustCart('DELETE');
    }

    async adjustCart(httpMethod, quantity) {
        try {
            const params = {
                method: httpMethod,
            }

            if (typeof quantity !== 'undefined' && quantity !== null) {
                params.headers = { 'Content-Type': 'application/x-www-form-urlencoded' };
                params.body = new URLSearchParams({ quantity });
            }

            const response = await fetch(`/carts/items/${encodeURIComponent(this.productIdValue)}/${encodeURIComponent(this.uomValue)}`, params);

            if (response.ok) {
                const contentType = response.headers.get('Content-Type') || '';

                if (contentType.includes('text/vnd.turbo-stream.html')) {
                    const html = await response.text();
                    Turbo.renderStreamMessage(html);
                }
            }
        } catch (error) {
        }
    }
}