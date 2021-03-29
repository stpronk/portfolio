@extends('layouts.app')

@section('content')

    <div class="row avenir">
        <div class="col-12 col-md-6 col-lg-8">
            <div class="card">
                <div class="card-header">
                    Map
                </div>

                <div class="card-body">
                    <div class="map-wrapper">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    Events
                </div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/eventPlanner.js') }}"></script>
@endsection
