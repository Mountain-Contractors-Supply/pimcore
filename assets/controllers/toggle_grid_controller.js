import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["grid", "viewToggleBtn"]

    toggleGrid() {
        const grid = this.gridTarget;
        const button = this.viewToggleBtnTarget;

        grid.classList.toggle('expanded');

        if (grid.classList.contains('expanded')) {
            button.innerHTML = 'VIEW LESS ▲';
        } else {
            button.innerHTML = 'VIEW MORE ▼';
        }
    }
}
