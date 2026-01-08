import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ["menu"]

    connect() {
        console.log('Header controller connected!')
        console.log('Has menu target:', this.hasMenuTarget)

        this.clickOutsideHandler = this.clickOutside.bind(this)
        document.addEventListener('click', this.clickOutsideHandler)
    }

    disconnect() {
        console.log('Header controller disconnected!')
        document.removeEventListener('click', this.clickOutsideHandler)
    }

    toggle(event) {
        console.log('Toggle clicked!')
        event.preventDefault()
        event.stopPropagation()

        if (this.hasMenuTarget) {
            this.menuTarget.classList.toggle('show')
            console.log('Menu has show class:', this.menuTarget.classList.contains('show'))
        } else {
            console.error('Menu target not found!')
        }
    }

    clickOutside(event) {
        if (this.hasMenuTarget && !this.element.contains(event.target)) {
            this.menuTarget.classList.remove('show')
        }
    }
}