import { Dealer } from './dealer'
import {Car} from "./car";

class App {
  constructor () {
    this.app = document.querySelector('#app');

    this.cards = document.querySelector('#car-cards');

    this.form = {
      'selector': this.app.querySelector('#car-form'),
      'fields' : {
        'uuid' : null,
        'brand' : null,
        'model' : null,
        'color' : null,
        'license' : null,
        'towbar' : null,
        'consumption' : null,
        'fuel_tank' : null,
        'fuel_left' : null,
        'mileage' : null
      }
    };

    Object.keys(this.form.fields).forEach((key) => {
      this.form.fields[key] = this.form.selector.querySelector(`[name=${key}]`);
    });

    this.addEventListeners();
    this.dealer = new Dealer(this);
  }

  /**
   * add the eventListeners of the application
   */
  addEventListeners () {
    // Add event listener for form submit
    this.form.selector.addEventListener('submit', ( event ) => {
      event.preventDefault();

      this.submitForm(event);
    });

    // Add event listener for form reset
    this.form.selector.querySelector('[type=\'reset\']').addEventListener('click', ( event ) => {
      event.preventDefault();

      this.resetForm();
    });
  }

  /**
   * Submit the form
   */
  submitForm () {
    const attributes = {};

    Object.keys(this.form.fields).forEach((key) => {
      attributes[key] = this.form.fields[key].value;
    });

    this.dealer.persist(attributes);
    this.resetForm();
  }

  /**
   * Reset the form
   */
  resetForm () {
    Object.keys(this.form.fields).forEach((key) => {
      this.form.fields[key].value = '';
    })
  }

  /**
   * Set the localStorage data
   */
  setLocalStorage ( key, value ) {
    return localStorage.setItem(key, JSON.stringify(value));
  }

  /**
   * Get the localStorage data
   *
   * @returns {any}
   */
  getLocalStorage ( key ) {
    return JSON.parse(localStorage.getItem(key));
  }

  fillForm (attributes, uuid = null) {
    if( uuid !== null) {
      this.form.selector.querySelector('[name=uuid').value = uuid;
    }

    Object.keys(attributes).forEach((key) => {
      this.form.fields[key].value = attributes[key];
    });
  }

  createCard ( uuid, car ) {
    if ( document.querySelector(`[data-uuid=car-${uuid}]`) ) {
      return this.updateCard(uuid, car);
    }

    const card = document.createElement('div');
    card.classList.add('col-12', 'pb-3');
    card.setAttribute('data-sort', 'card');
    card.setAttribute('data-uuid', `car-${uuid}`);
    card.innerHTML += `
            <div class="card">
                <div class="card-header">
                    ${uuid}
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-borderless">
                        <tr>
                            <td>Brand</td>
                            <td data-attribute="brand">${car.attributes.brand}</td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td data-attribute="model">${car.attributes.model}</td>
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td data-attribute="color">${car.attributes.color}</td>
                        </tr>
                        <tr>
                            <td>License</td>
                            <td data-attribute="license">${car.attributes.license}</td>
                        </tr>
                        <tr>
                            <td>Towbar</td>
                            <td data-attribute="towbar">${car.attributes.towbar}</td>
                        </tr>
                        <tr>
                            <td>Consumption</td>
                            <td><span data-attribute="consumption">${car.attributes.consumption}</span>/1</td>
                        </tr>
                        <tr>
                            <td>Fuel tank</td>
                            <td data-attribute="fuel_tank">${car.attributes.fuel_tank}</td>
                        </tr>
                        <tr>
                            <td>Fuel left</td>
                            <td data-attribute="fuel_left">${car.attributes.fuel_left}</td>
                        </tr>
                        <tr>
                            <td>Mileage</td>
                            <td data-attribute="mileage">${car.attributes.mileage}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button data-uuid="${uuid}" type="edit" class="btn btn-secondary">Edit <i class="fa fa-pencil"></i></button>
                        <button data-uuid="${uuid}" type="delete" class="btn btn-danger">Delete <i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
    `;

    card.querySelector('.btn[type=delete]').addEventListener('click',(event) => {
      this.dealer.remove( event.target.getAttribute('data-uuid') );
      card.remove();
    });

    card.querySelector('.btn[type=edit]').addEventListener('click', () => {
      this.fillForm(car.attributes, uuid);
    });

    this.cards.append(card);
  }

  updateCard ( uuid, car ) {
    const card = document.querySelector(`[data-uuid=car-${uuid}]`);

    Object.keys(car.attributes).forEach((key) => {
      card.querySelector(`[data-attribute=${key}]`).innerHTML = car.attributes[key];
    })
  }
}

const app = new App();