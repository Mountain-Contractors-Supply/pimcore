import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['track'];

    next() {
        this.rotateNext();
    }

    prev() {
        this.rotatePrev();
    }

    rotateNext() {
        const track = this.trackTarget;
        const first = track.firstElementChild;
        if (first) {
            track.style.transition = 'transform 0.5s ease-in-out';
            track.style.transform = `translateX(-${first.offsetWidth + 16}px)`;
            
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
            track.style.transition = 'none';
            track.insertBefore(last, track.firstElementChild);
            track.style.transform = `translateX(-${last.offsetWidth + 16}px)`;
            
            track.offsetHeight;
            
            track.style.transition = 'transform 0.5s ease-in-out';
            track.style.transform = 'translateX(0)';
        }
    }
}
