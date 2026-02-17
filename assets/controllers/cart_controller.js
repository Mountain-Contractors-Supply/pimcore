import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["qtyInput", "decreaseBtn", "increaseBtn", "inCartMessage"];
    static values = {
        productId: String,
        uom: String,
        minQuantity: { type: Number, default: 1 }
    };

    connect() {
        this.updateInCartDisplay();
    }

    async add() {
        const quantity = Math.max(this.minQuantityValue, parseInt(this.qtyInputTarget?.value, 10) || this.minQuantityValue);
        await this.adjustCart('POST', quantity);

        if (this.qtyInputTarget) {
            this.qtyInputTarget.value = String(this.minQuantityValue);
        }

        await this.updateInCartDisplay();
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

    async updateInCartDisplay() {
        if (!this.hasInCartMessageTarget) return;

        try {
            const response = await fetch('/carts');
            if (!response.ok) {
                this.inCartMessageTarget.classList.add('hidden');
                return;
            }

            const cart = await response.json();
            
            // Convert items to array if it's an object
            const itemsArray = Array.isArray(cart.items) ? cart.items : Object.values(cart.items || {});
            
            const item = itemsArray.find(i => 
                i.product?.productId === this.productIdValue && 
                i.quantityOrdered?.uom === this.uomValue
            );

            if (item && item.quantityOrdered?.quantity > 0) {
                this.inCartMessageTarget.textContent = `Currently in cart: ${item.quantityOrdered.quantity}`;
                this.inCartMessageTarget.classList.remove('hidden');
            } else {
                this.inCartMessageTarget.classList.add('hidden');
            }
        } catch (error) {
            this.inCartMessageTarget.classList.add('hidden');
        }
    }
}