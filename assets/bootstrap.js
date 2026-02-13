import { startStimulusApp } from '@symfony/stimulus-bundle';
import * as Turbo from '@hotwired/turbo';
import CartController from './controllers/cart_controller.js';
import RefreshController from './controllers/refresh_controller.js';
import CheckoutController from './controllers/checkout_controller.js';
import HeaderController from './controllers/header_controller.js';
import HomeController from './controllers/home_controller.js';
import LocationsController from './controllers/locations_controller.js';
import CarouselController from './controllers/carousel_controller.js';
import NumericInputController from './controllers/numeric_input_controller.js';

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
app.register('numeric-input', NumericInputController);

Turbo.StreamActions.reload_frame = function () {
    this.targetElements.forEach((frame) => {
        if (frame.reload) {
            frame.reload();
        }
    })
}