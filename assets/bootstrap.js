import { startStimulusApp } from '@symfony/stimulus-bundle';
import * as Turbo from '@hotwired/turbo';

const app = startStimulusApp();
const { fetch: originalFetch } = window;

window.fetch = async (...args) => {
    const response = await originalFetch(...args);
    const eventName = response.headers.get('X-Reload');

    if (eventName) {
        window.dispatchEvent(new CustomEvent(eventName));
    }

    return response;
};

Turbo.StreamActions.reload_frame = function () {
    this.targetElements.forEach((frame) => {
        if (frame.reload) {
            frame.reload();
        }
    })
}