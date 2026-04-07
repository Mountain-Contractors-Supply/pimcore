import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = { searchPath: String };

    connect() {
        document.addEventListener('turbo:before-fetch-request', this.#onBeforeVisit);
        document.addEventListener('turbo:load', this.#onLoad);
    }

    disconnect() {
        document.removeEventListener('turbo:before-fetch-request', this.#onBeforeVisit);
        document.removeEventListener('turbo:load', this.#onLoad);
    }

    #onBeforeVisit = (event) => {
        const urlStr = String(event?.detail?.url ?? '');
        const isSearchPage = urlStr.includes('/category/search');

        if (!isSearchPage) {
            this.element.blur();
        }
    };

    #onLoad = () => {
        const isSearchPage = window.location.href.includes('/category/search');

        if (!isSearchPage) {
            this.element.value = '';
            this.element.dispatchEvent(new Event('input', { bubbles: true }));
            this.element.blur();
        }
    };
}