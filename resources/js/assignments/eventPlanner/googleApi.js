class GoogleApi {
    constructor(app) {
        this.app = app;
        this.wrapper = document.querySelector('.map-wrapper')
        this.google = require('https://maps.googleapis.com/maps/api/js?key=AIzaSyDiBEuU97vDruJ6ZpMqKxzj-rlEcfSqyT8&callback=initMap&libraries=&v=weekly');
        this.map = this.init();
    }

    init () {
        return new this.google.maps.Map(this.wrapper, {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        });
    }
}
