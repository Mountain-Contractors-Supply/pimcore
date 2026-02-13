import { startStimulusApp } from '@symfony/stimulus-bundle';
import * as Turbo from '@hotwired/turbo';
import MapController from '@symfony/ux-google-map';

const app = startStimulusApp();
const { fetch: originalFetch } = window;

window.fetch = async (...args) => {
    const response = await originalFetch(...args);
    const eventName = response.headers.get('X-Custom-Event');

    if (eventName) {
        window.dispatchEvent(new CustomEvent(eventName));
    }

    return response;
};
app.register('symfony--ux-google-map--map', MapController);

Turbo.StreamActions.reload_frame = function () {
    this.targetElements.forEach((frame) => {
        if (frame.reload) {
            frame.reload();
        }
    })
}