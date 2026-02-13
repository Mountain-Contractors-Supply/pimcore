import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["qtyInput", "decreaseBtn", "increaseBtn"];
    static values = {
        productId: String,
        uom: String,
        minQuantity: { type: Number, default: 1 }
    };

    async add(event) {
        event.preventDefault();

        const quantity = Math.max(this.minQuantityValue, parseInt(this.qtyInputTarget?.value, 10) || this.minQuantityValue);

        try {
            await fetch(`/carts/items/${encodeURIComponent(this.productIdValue)}/${encodeURIComponent(this.uomValue)}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ quantity })
            });

            window.dispatchEvent(new CustomEvent('cart-updated'));
        } catch (error) {
            console.error('Error adding to cart:', error);
        }
    }

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

    inputChanged() {
        const newQty = Math.max(this.minQuantityValue, parseInt(this.qtyInputTarget.value, 10) || this.minQuantityValue);

        this.qtyInputTarget.value = newQty;
        this.updateQuantity(newQty);
    }

    async updateQuantity(quantity) {
        try {
            await fetch(`/carts/items/${encodeURIComponent(this.productIdValue)}/${encodeURIComponent(this.uomValue)}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({quantity})
            });
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }

    async remove() {
        try {
            await fetch(`/carts/items/${encodeURIComponent(this.productIdValue)}/${encodeURIComponent(this.uomValue)}`, {
                method: 'DELETE'
            });
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }
}