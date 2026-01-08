import { startStimulusApp } from '@symfony/stimulus-bundle';
import * as Turbo from '@hotwired/turbo';

const app = startStimulusApp();

Turbo.StreamActions.reload_frame = function () {
    this.targetElements.forEach((frame) => {
        if (frame.reload) {
            frame.reload();
        }
    })
}