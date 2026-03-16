import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ["menu"]

    connect() {
        this.clickOutsideHandler = this.clickOutside.bind(this)
        document.addEventListener('click', this.clickOutsideHandler)
    }

    disconnect() {
        document.removeEventListener('click', this.clickOutsideHandler)
    }

    toggle(event) {
        event.preventDefault()
        event.stopPropagation()

        if (this.hasMenuTarget) {
            this.menuTarget.classList.toggle('show')
        }
    }

    clickOutside(event) {
        if (this.hasMenuTarget && !this.element.contains(event.target)) {
            this.menuTarget.classList.remove('show')
        }
    }
}