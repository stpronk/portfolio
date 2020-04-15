export class Car {
  constructor ( attributes = {} ) {
    this.attributes = this.map( attributes );
  }

  update ( attributes ) {
    if( this.attributes.mileage === parseFloat(attributes.mileage) && this.attributes.fuel_left > parseFloat(attributes.fuel_left) ) {
      attributes.mileage = this.updateMileage( parseFloat(attributes.fuel_left), parseFloat(attributes.consumption) );
    }

    if( this.attributes.fuel_left === parseFloat(attributes.fuel_left) && this.attributes.mileage < parseFloat(attributes.mileage) ) {
      attributes.fuel_left = this.updateFuelLeft( parseFloat(attributes.mileage), parseFloat(attributes.consumption), parseFloat(attributes.fuel_tank ) );
    }

    this.attributes = this.map( attributes );
  }

  updateMileage ( fuel_left, consumption ) {
    return this.attributes.mileage + ( (this.attributes.fuel_left - fuel_left) * consumption);
  }

  updateFuelLeft ( mileage, consumption, interval ) {
    return ((((mileage - this.attributes.mileage ) / consumption - this.attributes.fuel_left ) % interval ) - interval ) * -1;
  }

  /**
   * Mapper
   *
   * @param attributes
   * @returns {{license: (*|string), towbar: *, color: (null|string|string), model: (*|model$1|{value: string; callback: string; expression: string}|null|string|string), consumption: *, fuel_left: *, fuel_tank: *, brand: (null|string), mileage: *}}
   */
  map ( attributes ) {
    return {
      'brand' : ( attributes.brand ?? this.attributes.brand ) ?? 'N/A',
      'model' : ( attributes.model ?? this.attributes.model ) ?? 'N/A',
      'color' : ( attributes.color ?? this.attributes.color )  ?? 'N/A',
      'license' : ( attributes.license ?? this.attributes.license ) ?? 'N/A',
      'towbar' : parseInt(( attributes.towbar ?? this.attributes.towbar ) ?? 0 ),
      'consumption' : parseFloat( ( attributes.consumption ?? this.attributes.consumption ) ?? 0 ),
      'fuel_tank' : parseFloat( ( attributes.fuel_tank ?? this.attributes.fuel_tank ) ?? 0 ),
      'fuel_left' : parseFloat( ( attributes.fuel_left ?? this.attributes.fuel_left ) ?? 0 ),
      'mileage' : parseFloat( ( attributes.mileage ?? this.attributes.mileage ) ?? 0 )
    }
  }
}