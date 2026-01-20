import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    copy(event) {
        const button = event.currentTarget;
        const phoneNumber = button.dataset.phoneNumber || '';

        if (!phoneNumber) return;

        if (!navigator.clipboard || !navigator.clipboard.writeText) {
            return;
        }

        navigator.clipboard.writeText(phoneNumber)
            .then(() => {
                alert('Phone number copied to clipboard: ' + phoneNumber);
            })
            .catch(() => {
                // Silently fail if copy not available / permission denied
            });
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
            const response = await fetch('/carts/ship-branch', {
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