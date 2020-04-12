@extends('layouts.app')

@section('content')
    <div id="app" class="row">
        <div class="col-4">
            <div class="card">
                <form id="car-form">
                    <div class="card-header">
                        Create new car
                    </div>
                    <div class="card-body">
                        <label for="uuid" class="form-group form-check-label w-100">
                            UUID: <input name="uuid" class="form-control" value="" placeholder="" disabled>
                        </label>

                        <label for="brand" class="form-group form-check-label w-100 pt-3">
                            Brand: <input name="brand" class="form-control" value="" placeholder="Brand">
                        </label>

                        <label for="model" class="form-group form-check-label w-100 pt-3">
                            Model: <input name="model" class="form-control" value="" placeholder="Model">
                        </label>

                        <label for="color" class="form-group form-check-label w-100 pt-3">
                            Color: <input name="color" class="form-control" value="" placeholder="Color">
                        </label>

                        <label for="license" class="form-group form-check-label w-100 pt-3">
                            License: <input name="license" class="form-control" value="" placeholder="License">
                        </label>

                        <label for="towbar" class="form-group form-check-label w-100 pt-3">
                            Towbar: <input name="towbar" class="form-control" value="" placeholder="Towbar" type="number" min="0" max="1">
                            <small>0 = False / 1 = True</small>
                        </label>

                        <label for="consumption" class="form-group form-check-label w-100 pt-3">
                            Consumption:
                            <div class="input-group">
                                <input name="consumption" class="form-control w-100" value="" placeholder="Consumption">
                                <div class="input-group-append">
                                    <div class="input-group-text">/1</div>
                                </div>
                            </div>
                        </label>

                        <label for="fuel_tank" class="form-group form-check-label w-100 pt-3">
                            Fuel tank: <input name="fuel_tank" class="form-control" value="" placeholder="Fuel tank">
                        </label>

                        <label for="fuel_left" class="form-group form-check-label w-100 pt-3">
                            Fuel left: <input name="fuel_left" class="form-control" value="" placeholder="Fuel left">
                        </label>

                        <label for="mileage" class="form-group form-check-label w-100 pt-3">
                            Mileage: <input name="mileage" class="form-control" value="" placeholder="Mileage">
                        </label>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100">
                            <button class="btn btn-secondary" type="reset">Cancel <i class="fa fa-trash-o"></i></button>
                            <button class="btn btn-primary" type="submit">Save <i class="fa fa-floppy-o"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="car-cards" class="row col-8" style="align-content: flex-start">
{{--            Cards are injected through Javascript           --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dealer.js') }}"></script>
@endsection