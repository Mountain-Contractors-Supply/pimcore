import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static values = {
        delay: { type: Number, default: 350 }
    };

    connect() {
        this.timeoutId = null;
    }

    disconnect() {
        if (this.timeoutId !== null) {
            clearTimeout(this.timeoutId);
            this.timeoutId = null;
        }
    }

    submitNow() {
        if (this.timeoutId !== null) {
            clearTimeout(this.timeoutId);
            this.timeoutId = null;
        }

        this.requestSubmit();
    }

    queueSubmit(event) {
        // Only debounce free-text fields; checkbox/radio/select are handled by change.
        if (!(event.target instanceof HTMLInputElement) || event.target.type !== "text") {
            return;
        }

        if (this.timeoutId !== null) {
            clearTimeout(this.timeoutId);
        }

        this.timeoutId = setTimeout(() => {
            this.requestSubmit();
            this.timeoutId = null;
        }, this.delayValue);
    }

    requestSubmit() {
        if (typeof this.element.requestSubmit === "function") {
            this.element.requestSubmit();
            return;
        }

        this.element.submit();
    }
}
