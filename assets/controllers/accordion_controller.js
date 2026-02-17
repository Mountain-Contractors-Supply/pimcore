import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["item"];
    static ANIMATION_DURATION = 300;

    toggle(event) {
        const clickedSummary = event.currentTarget;
        const clickedDetails = clickedSummary.closest('details');
        
        event.preventDefault();
        
        const wasOpen = clickedDetails.open;
        
        this.itemTargets.forEach(details => {
            if (details !== clickedDetails && details.open) {
                this.closeDetails(details);
            }
        });
        
        if (wasOpen) {
            this.closeDetails(clickedDetails);
        } else {
            this.openDetails(clickedDetails);
        }
    }

    openDetails(details) {
        const content = details.querySelector('div');
        
        details.open = true;
        details.style.overflow = 'hidden';
        
        const fullHeight = content.scrollHeight;
        
        content.style.height = '0px';
        content.style.opacity = '0';
        content.style.overflow = 'hidden';
        
        requestAnimationFrame(() => {
            content.style.transition = 'height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            content.style.height = fullHeight + 'px';
            content.style.opacity = '1';
        });
        
        setTimeout(() => {
            content.style.height = '';
            content.style.opacity = '';
            content.style.overflow = '';
            content.style.transition = '';
            details.style.overflow = '';
        }, this.constructor.ANIMATION_DURATION);
    }

    closeDetails(details) {
        const content = details.querySelector('div');
        
        const currentHeight = content.scrollHeight;
        content.style.height = currentHeight + 'px';
        content.style.overflow = 'hidden';
        details.style.overflow = 'hidden';
        
        requestAnimationFrame(() => {
            content.style.transition = 'height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            content.style.height = '0px';
            content.style.opacity = '0';
        });
        
        setTimeout(() => {
            details.open = false;
            content.style.height = '';
            content.style.opacity = '';
            content.style.overflow = '';
            content.style.transition = '';
            details.style.overflow = '';
        }, this.constructor.ANIMATION_DURATION);
    }
}
