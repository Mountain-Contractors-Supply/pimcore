import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input', 'category', 'suggestions'];
    static values = {
        url: String,
        debounce: { type: Number, default: 300 }
    };

    connect() {
        this.abortController = null;
        this.timeout = null;
        this.isOpen = false;

        // Close dropdown when clicking outside
        this.boundHandleClickOutside = this.handleClickOutside.bind(this);
        document.addEventListener('click', this.boundHandleClickOutside);
    }

    disconnect() {
        if (this.abortController) {
            this.abortController.abort();
        }
        if (this.timeout) {
            clearTimeout(this.timeout);
        }
        document.removeEventListener('click', this.boundHandleClickOutside);
    }

    handleClickOutside(event) {
        if (!this.element.contains(event.target)) {
            this.close();
        }
    }

    handleEnter(event) {
        if (event.key === 'Enter') {
            this.close();
            // Blur the input to remove focus
            requestAnimationFrame(() => {
                this.inputTarget.blur();
            });
        }
    }

    open() {
        this.isOpen = true;
        this.suggestionsTarget.classList.remove('hidden');
    }

    close() {
        this.isOpen = false;
        this.suggestionsTarget.classList.add('hidden');
    }

    onFocus() {
        if (this.inputTarget.value.trim().length > 0) {
            this.open();
        }
    }

    async search(event) {
        const query = this.inputTarget.value.trim();
        const categoryId = this.categoryTarget.value;

        // Clear previous timeout
        if (this.timeout) {
            clearTimeout(this.timeout);
        }

        // Debounce the search
        this.timeout = setTimeout(async () => {
            if (query.length === 0) {
                this.close();
                return;
            }

            await this.fetchSuggestions(query, categoryId);
            this.open();
        }, this.debounceValue);
    }

    async fetchSuggestions(query, categoryId) {
        // Cancel previous request
        if (this.abortController) {
            this.abortController.abort();
        }

        this.abortController = new AbortController();

        try {
            const url = new URL(this.urlValue, window.location.origin);
            url.searchParams.set('q', query);
            url.searchParams.set('id', categoryId);

            const response = await fetch(url, {
                signal: this.abortController.signal,
                headers: {
                    'Accept': 'text/vnd.turbo-stream.html'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const html = await response.text();
            Turbo.renderStreamMessage(html);
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Search failed:', error);
            }
        }
    }
}