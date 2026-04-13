import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input'];

    connect() {
        this._lastValue = String(this.inputTarget.value || '');
    }

    onNativeChange(event) {
        const value = String(this.inputTarget.value || '');
        if (value === this._lastValue) return;
        this._lastValue = value;
        this.emitChanged(value);
    }

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
        this.emitChanged(next);
    }

    emitChanged(value) {
        this.inputTarget.dispatchEvent(new CustomEvent('numeric-input:changed', {
            bubbles: true,
            composed: true,
            detail: { value }
        }));
    }
}