import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['track'];

    connect() {
        console.log('Carousel controller connected', this.element);
    }

    next() {
        console.log('Next clicked');
        this.rotateNext();
    }

    prev() {
        console.log('Prev clicked');
        this.rotatePrev();
    }

    rotateNext() {
        const track = this.trackTarget;
        const first = track.firstElementChild;
        if (first) {
            // Add transition and shift left
            track.style.transition = 'transform 0.5s ease-in-out';
            track.style.transform = `translateX(-${first.offsetWidth + 16}px)`; // 16px is gap
            
            // After animation completes, move element and reset
            setTimeout(() => {
                track.style.transition = 'none';
                track.style.transform = 'translateX(0)';
                track.appendChild(first);
            }, 500);
        }
    }

    rotatePrev() {
        const track = this.trackTarget;
        const last = track.lastElementChild;
        if (last) {
            // Move element first without animation
            track.style.transition = 'none';
            track.insertBefore(last, track.firstElementChild);
            track.style.transform = `translateX(-${last.offsetWidth + 16}px)`; // 16px is gap
            
            // Force reflow
            track.offsetHeight;
            
            // Animate back to position
            track.style.transition = 'transform 0.5s ease-in-out';
            track.style.transform = 'translateX(0)';
        }
    }
}
