import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static values = { url: String };

    connect() {
        this._reload = () => {
            if (typeof this.element.reload === 'function') {
                this.element.reload();
            } else if (this.hasUrlValue) {
                this.element.setAttribute('src', this.urlValue);
            }
        };
        document.addEventListener('cart:item:removed', this._reload);
        document.addEventListener('cart:updated', this._reload);
    }

    disconnect() {
        document.removeEventListener('cart:item:removed', this._reload);
        document.removeEventListener('cart:updated', this._reload);
    }
}
