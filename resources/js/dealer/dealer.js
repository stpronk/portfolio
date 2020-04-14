import { Car } from './car';
import { v4 as uuidv4 } from 'uuid'

export class Dealer {

  constructor (app) {
    /**
     * Setup the app variable
     */
    this.app = app;

    /**
     * The cars variable
     */
    this.cars = {};

    /**
     * Sets up all the cars that were in the localStorage
     */
    Object.keys(this.app.getLocalStorage('cars') ?? {} ).forEach((key) => {
      const car = new Car(this.app.getLocalStorage('cars')[key].attributes);
      this.cars[key] = car;
      this.app.createCard(key, car)
    });
  }

  /**
   * Persist a new car
   *
   * @param attributes
   */
  persist( attributes = {} ) {
    if ( !attributes.uuid ) {
      attributes.uuid = uuidv4();
      this.cars[attributes.uuid] = new Car(attributes);
    } else {
      this.cars[attributes.uuid].update(attributes);
    }

    this.app.createCard( attributes.uuid, this.cars[attributes.uuid] );
    this.app.setLocalStorage('cars', this.cars);
  }

  /**
   * Remove the card from the list
   *
   * @param uuid
   */
  remove ( uuid ) {
    delete this.cars[uuid];

    this.app.setLocalStorage('cars', this.cars);
  }
}