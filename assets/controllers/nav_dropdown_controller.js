import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['menu']

    connect() {
        this.close()
    }

    open() {
        if (this.hasMenuTarget) {
            this.menuTarget.classList.remove('hidden')
        }
    }

    close() {
        if (this.hasMenuTarget) {
            this.menuTarget.classList.add('hidden')
        }
    }

    maybeClose(event) {
        if (!this.hasMenuTarget) {
            return
        }

        const next = event.relatedTarget
        if (next && this.element.contains(next)) {
            return
        }

        this.close()
    }
}
