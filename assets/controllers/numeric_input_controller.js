import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input'];

    increase() {
        this.step(1);
    }

    decrease() {
        this.step(-1);
    }

    step(direction) {
        const input = this.inputTarget;
        const step = Number(input.step || 1);
        const min = input.min !== '' ? Number(input.min) : null;
        const max = input.max !== '' ? Number(input.max) : null;
        const current = Number(input.value || 0);

        let next = current + (step * direction);

        if (min !== null && next < min) next = min;
        if (max !== null && next > max) next = max;

        input.value = next;
        input.dispatchEvent(new Event('change', { bubbles: true }));
    }
}
