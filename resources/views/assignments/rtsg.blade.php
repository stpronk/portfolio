@extends('layouts.app')

@section('content')
    <div class="col-12 row pb-3">
        <div class="col-3">
            <div class="card resource-metal">
                <div class="card-header">
                    Metal
                </div>
                <div class="card-body">
                    <span class="storage">1.000</span> <span class="production text-success">+50</span>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card resource-kristal">
                <div class="card-header">
                    Kristal
                </div>
                <div class="card-body">
                    <span class="storage">500</span> <span class="production text-success">+10</span>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card resource-uranium">
                <div class="card-header">
                    Uranium
                </div>
                <div class="card-body">
                    <span class="storage">0</span> <span class="production text-success">+0</span>
                </div>
            </div>
        </div>


        <div class="col-3">
            <div class="card resource-energy">
                <div class="card-header">
                    Energy
                </div>
                <div class="card-body">
                    <span class="production text-success">+0</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-cog"></i> Resource Buildings
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped">
                    <tr class="building-metal">
                        <td>Metal mine</td>
                        <td>Description</td>
                        <td class="cost">
                            Metal: 250 <br>
                            Kristal: 50 <br>
                            Energy: 10 <br>
                            Time: 00:00:30
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-sm btn-success upgrade"><i class="fa fa-arrow-up"></i> Upgrade</button>
                                <button class="btn btn-sm btn-info text-white"><i class="fa fa-info"></i> Information</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Kristal mine</td>
                        <td>Description</td>
                        <td>Cost</td>
                        <td>Action</td>
                    </tr>
                    <tr>
                        <td>Uranium extractor</td>
                        <td>Description</td>
                        <td>Cost</td>
                        <td>Action</td>
                    </tr>
                    <tr>
                        <td>Power plant</td>
                        <td>Description</td>
                        <td>Cost</td>
                        <td>Action</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/rtsg.js') }}"></script>
@stop