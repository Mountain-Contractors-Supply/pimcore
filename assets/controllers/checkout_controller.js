import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["checkbox", "savedAddressSection", "newAddressSection"]

    connect() {
        this.toggle()
    }

    toggle() {
        const isChecked = this.checkboxTarget.checked

        if (isChecked) {
            this.savedAddressSectionTarget.style.display = 'none'
            this.newAddressSectionTarget.style.display = 'block'
        } else {
            this.savedAddressSectionTarget.style.display = 'block'
            this.newAddressSectionTarget.style.display = 'none'
        }
    }
}