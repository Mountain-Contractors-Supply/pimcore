import { startStimulusApp } from '@symfony/stimulus-bundle';
import * as Turbo from '@hotwired/turbo';
import MapController from '@symfony/ux-google-map';

const app = startStimulusApp();
app.register('symfony--ux-google-map--map', MapController);

Turbo.StreamActions.reload_frame = function () {
    this.targetElements.forEach((frame) => {
        if (frame.reload) {
            frame.reload();
        }
    })
}