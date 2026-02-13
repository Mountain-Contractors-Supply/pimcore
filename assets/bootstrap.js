import { startStimulusApp } from '@symfony/stimulus-bundle';
import * as Turbo from '@hotwired/turbo';


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

app.register('cart', CartController);
app.register('refresh', RefreshController);
app.register('checkout', CheckoutController);
app.register('header', HeaderController);
app.register('home', HomeController);
app.register('locations', LocationsController);
app.register('carousel', CarouselController);
app.register('alert-banner', AlertBannerController);
app.register('numeric-input', NumericInputController);

Turbo.StreamActions.reload_frame = function () {
    this.targetElements.forEach((frame) => {
        if (frame.reload) {
            frame.reload();
        }
    })
}