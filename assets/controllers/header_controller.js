import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ["menu", "mobileMenu"]

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
            this.menuTarget.classList.toggle('hidden')
        }
    }

    toggleMobile(event) {
        event.stopPropagation()

        if (this.hasMobileMenuTarget) {
            this.mobileMenuTarget.classList.toggle('hidden')
        }
    }

    closeMobile() {
        if (this.hasMobileMenuTarget) {
            this.mobileMenuTarget.classList.add('hidden')
        }
    }

    closeMobileOnLink(event) {
        if (event.target.closest('a')) {
            this.closeMobile()
        }
    }

    clickOutside(event) {
        if (this.hasMenuTarget && !this.element.contains(event.target)) {
            this.menuTarget.classList.add('hidden')
        }
        if (this.hasMobileMenuTarget && !this.element.contains(event.target)) {
            this.mobileMenuTarget.classList.add('hidden')
        }
    }
}