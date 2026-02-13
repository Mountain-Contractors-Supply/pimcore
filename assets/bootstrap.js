import { startStimulusApp } from '@symfony/stimulus-bundle';
import * as Turbo from '@hotwired/turbo';
import MapController from '@symfony/ux-google-map';
import CartController from './controllers/cart_controller';
import RefreshController from './controllers/refresh_controller';
import CheckoutController from './controllers/checkout_controller';
import HeaderController from './controllers/header_controller';
import HomeController from './controllers/home_controller';
import LocationsController from './controllers/locations_controller';

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
app.register('cart', CartController);
app.register('refresh', RefreshController);
app.register('checkout', CheckoutController);
app.register('header', HeaderController);
app.register('home', HomeController);
app.register('locations', LocationsController);

Turbo.StreamActions.reload_frame = function () {
    this.targetElements.forEach((frame) => {
        if (frame.reload) {
            frame.reload();
        }
    })
}