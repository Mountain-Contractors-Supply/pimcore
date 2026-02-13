import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["qtyInput", "decreaseBtn", "increaseBtn"];
    static values = {
        productId: String,
        uom: String,
        minQuantity: { type: Number, default: 1 }
    };

    async add() {
        const quantity = Math.max(this.minQuantityValue, parseInt(this.qtyInputTarget?.value, 10) || this.minQuantityValue);
        await this.adjustCart('POST', quantity);
    }

    async decrease() {
        const currentQty = parseInt(this.qtyInputTarget.value, 10) || this.minQuantityValue;
        const newQty = Math.max(this.minQuantityValue, currentQty - 1);

        if (newQty !== currentQty) {
            await this.updateQuantity(newQty);
        }
    }

    async increase() {
        const currentQty = parseInt(this.qtyInputTarget.value, 10) || this.minQuantityValue;
        const newQty = currentQty + 1;
        await this.updateQuantity(newQty);
    }

    async updateQuantity(quantity) {
        await this.adjustCart('PUT', quantity);
    }

    async remove() {
        await this.adjustCart('DELETE');
    }

    async inputChanged() {
        const newQty = Math.max(this.minQuantityValue, parseInt(this.qtyInputTarget.value, 10) || this.minQuantityValue);

        this.qtyInputTarget.value = newQty;
        await this.updateQuantity(newQty);
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

            await fetch(`/carts/items/${encodeURIComponent(this.productIdValue)}/${encodeURIComponent(this.uomValue)}`, params);
        } catch (error) {
        }
    }
}