import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["grid", "viewToggleBtn"]

    connect() {
        console.log('Toggle grid controller connected');
    }

    toggleGrid() {
        console.log('Toggle called');
        const grid = this.gridTarget;
        const button = this.viewToggleBtnTarget;
        
        console.log('Grid:', grid);
        console.log('Has expanded class:', grid.classList.contains('expanded'));

        grid.classList.toggle('expanded');

        if (grid.classList.contains('expanded')) {
            button.innerHTML = 'VIEW LESS ▲';
        } else {
            button.innerHTML = 'VIEW MORE ▼';
        }
    }
}
