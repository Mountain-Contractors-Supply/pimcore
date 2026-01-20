import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["divisionsGrid", "viewToggleBtn", "expertBox"]

    toggleDivisions() {
        const grid = this.divisionsGridTarget;
        const button = this.viewToggleBtnTarget;

        grid.classList.toggle('expanded');

        if (grid.classList.contains('expanded')) {
            button.innerHTML = 'VIEW LESS ▲';
        } else {
            button.innerHTML = 'VIEW MORE ▼';
        }
    }

    toggleExpertBox(event) {
        const expertBox = event.currentTarget;
        expertBox.classList.toggle('expanded');
    }
}