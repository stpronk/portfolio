import './googleApi';

class App {
    constructor() {
        this.googleApi = new GoogleApi(this);
    }
}

const app = new App();
