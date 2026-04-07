import { Controller } from '@hotwired/stimulus';

let userIsActivelyTyping = false;
let typingTimeoutId = null;

export default class extends Controller {
    static values = { searchPath: String };

    connect() {
        if (userIsActivelyTyping) {
            requestAnimationFrame(() => this.element.focus());
        }
        document.addEventListener('turbo:before-visit', this.#onBeforeVisit);
        document.addEventListener('turbo:load', this.#onLoad);
        this.element.addEventListener('input', this.#onInput);
    }

    disconnect() {
        document.removeEventListener('turbo:before-visit', this.#onBeforeVisit);
        document.removeEventListener('turbo:load', this.#onLoad);
        this.element.removeEventListener('input', this.#onInput);
    }

    blur(event) {
        requestAnimationFrame(() => {
            event.target.blur();
        });
    }

    #onInput = () => {
        userIsActivelyTyping = true;
        clearTimeout(typingTimeoutId);
        typingTimeoutId = setTimeout(() => { userIsActivelyTyping = false; }, 1000);
    };

    #onBeforeVisit = (event) => {
        const isSearchPage = event.detail.url.includes('/category/search');

        if (!isSearchPage) {
            userIsActivelyTyping = false;
            clearTimeout(typingTimeoutId);
            this.element.blur();
        }
    };

    #onLoad = () => {
        const isSearchPage = window.location.href.includes('/category/search');

        if (!isSearchPage) {
            userIsActivelyTyping = false;
            clearTimeout(typingTimeoutId);
            this.element.value = '';
            this.element.blur();
        }
    };
}