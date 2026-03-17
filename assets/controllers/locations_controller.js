import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    toggleSidebar(event) {
        event.preventDefault();
        if (this.hasFilterContainerTarget) {
            this.filterContainerTarget.classList.toggle('hidden');
        }
        if (this.hasSidebarOverlayTarget) {
            this.sidebarOverlayTarget.classList.toggle('hidden');
        }
    }

    closeSidebar(event) {
        event.preventDefault();
        if (this.hasFilterContainerTarget) {
            this.filterContainerTarget.classList.add('hidden');
        }
        if (this.hasSidebarOverlayTarget) {
            this.sidebarOverlayTarget.classList.add('hidden');
        }
    }

    async setMainStore(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const branchIdRaw = button.dataset.branchId || '';
        const numericBranchId = parseInt(branchIdRaw, 10);

        if (Number.isNaN(numericBranchId)) {
            alert('Error: Invalid location ID. Please try again.');
            return;
        }

        try {
            await fetch('/carts/ship-branch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ branchId: numericBranchId }),
            });
        } catch (error) {
            alert('Unable to set main store. Please try again or contact support if the problem persists.');
        }
    }
}