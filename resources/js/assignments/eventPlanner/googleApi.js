class GoogleApi {
    constructor(app) {
        this.app = app;
        this.wrapper = document.querySelector('.map-wrapper')
        this.google = require('');
        this.map = this.init();
    }

    init () {
        return new this.google.maps.Map(this.wrapper, {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        });
    }
}
