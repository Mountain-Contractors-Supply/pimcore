import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["qtyInput", "decreaseBtn", "increaseBtn"];
    static values = {
        productId: String,
        uom: String,
        minQuantity: { type: Number, default: 1 }
    };

    decrease() {
        const currentQty = parseInt(this.qtyInputTarget.value, 10) || this.minQuantityValue;
        const newQty = Math.max(this.minQuantityValue, currentQty - 1);

        if (newQty !== currentQty) {
            this.updateQuantity(newQty);
        }
    }

    increase() {
        const currentQty = parseInt(this.qtyInputTarget.value, 10) || this.minQuantityValue;
        const newQty = currentQty + 1;
        this.updateQuantity(newQty);
    }

    remove() {
        this.deleteItem();
    }

    inputChanged() {
        const newQty = Math.max(this.minQuantityValue, parseInt(this.qtyInputTarget.value, 10) || this.minQuantityValue);

        this.qtyInputTarget.value = newQty;
        this.updateQuantity(newQty);
    }

    async updateQuantity(quantity) {
        if (!this.productIdValue || !this.uomValue) {
            console.error('Missing productId or uom values');
            return;
        }

        try {
            const body = new URLSearchParams({ quantity: String(quantity) });
            await fetch(`/carts/items/${encodeURIComponent(this.productIdValue)}/${encodeURIComponent(this.uomValue)}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body.toString()
            }).then(() => this.updateView());
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }

    async deleteItem() {
        if (!this.productIdValue || !this.uomValue) {
            console.error('Missing productId or uom values');
            return;
        }

        try {
            await fetch(`/carts/items/${encodeURIComponent(this.productIdValue)}/${encodeURIComponent(this.uomValue)}`, {
                method: 'DELETE'
            }).then(() => this.updateView());
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }

    updateView() {
        const frame = document.getElementById("cart-list-frame");
        if (frame && typeof frame.reload === "function") {
            frame.reload();
        }
    }
}