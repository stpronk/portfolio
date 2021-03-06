@extends('layouts.app', [
    'assignment' => [
        [
            'title'   => 'Assignment',
            'content' => "<p>
                    Competa IT gaat nu ook in de auto markt zitten. Hierbij willen wij een applicatie hebben waarbij wij kunnen bijhouden welke
                    auto's wij op vooraad hebben en hiervan de gegevens. deze gegeven zijn:
                </p>
                <ul>
                    <li>Merk</li>
                    <li>Model</li>
                    <li>Kleur</li>
                    <li>Kenteken</li>
                    <li>Trekhaak</li>
                    <li>Verbruik</li>
                    <li>Totale volume tank</li>
                    <li>Hoveel volume tank</li>
                    <li>Kilometer tank</li>
                </ul>
                <p>
                    Hiervoor is het belangrijk dat als wij een auto verhuren en wij krijgen hem terug, dat we de data kunnen bijwerken en dat
                    de rest wordt bijgewerkt, denk hieraan van het bijwerken van de kilometer stand waardoor de hoeveel van de tank dan
                    veranderd, ook moet deze hoeveelheid dan niet in de min komen te staan. Wanneer de tank wordt leeg gereden mag je er van
                    uit gaan dat de tank helemaal vol wordt gegooit. Deze auto's kunnen ook verkocht worden en dan moet deze ook uit het
                    systeem kunnen worden gehaald.
                </p>"
        ],
        [
            'title'   => 'Tips & Tricks',
            'content' => "<ul>
                <li>
                    Wanneer je de classes opzet voor de Javascript, noem ze naar wat ze zijn. Bijvoorbeeld dat als je voor een auto een
                    aparte class maakt, dan kan je deze letterlijk \"Car\" noemen.
                </li>
                <li>
                    Gebruik waar nodig zoveel mogelijk de enkelvoud van een woord, bijvoorbeeld \"Car\" ipv \"Cars\". Als je een class wilt die
                    de verschillende auto's regelt dan kan je beter naar een naam kijken zoals \"Dealer\"
                </li>
                <li>
                    Probeer het te houden bij 3 of 4 classes, meer is niet nodig. Gooit ook niet alles in 1 class, dat maakt het weer
                    onoverzichtelijk.
                </li>
                <li>
                    Bedenk van te voren een plan hoe je het in elkaar gaat zitten, begin niet gelijk met coderen.
                </li>
            </ul>"
        ],
        [
            'title'   => 'Required Results',
            'content' => "<ul>
                <li>Auto's moeten toegevoegd kunnen worden</li>
                <li>Auto's moeten gewijzigd kunnen worden</li>
                <li>Auto's moeten verwijderd kunnen worden</li>
                <li>Wanneer \"fuel\" gewijzigd wordt, moet de \"mileage\" automatish gewijzigd worden op basis van \"consumption\"</li>
                <li>Wanneer \"mileage\" gewijzigd wordt, moet de \"fuel\" automatish gewijzigd worden op basis van \"consumption\"</li>
                <li>Wanneer \"fuel\" en \"mileage\" bijde gewijzigd worden, wordt neits automatisch gewijzigd</li>
                <li>Auto's moeten worden opgeslagen in de localstorage</li>
                <li>Gebruik maken van Javascript classes en deze met elkaar laten communiseren</li>
                <li>Code moet op een logishe manier worden opgebouwd</li>
                <li>Code moet <span class='avenir-bold'>DRY</span> (Don't repeat yourself) zijn</li>
                <li>Redelijk design, moet overzichtelijk en logish zijn</li>
                <li><span class='avenir-bold'>GEEN</span> bootstrap</li>
                <li>Plain Javascript</li>
            </ul>"
        ],
    ]
])

@section('content')
    <div class="row avenir">
        <div class="col-12 col-md-4">

            <div class="card rounded-0 border-0">
                <form id="car-form">
                    <div class="card-header bg-light text-dark border-bottom border-primary rounded-0">
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

                        <label for="mileage" class="form-group form-check-label w-100 pt-4">
                            Mileage: <input name="mileage" class="form-control" value="" placeholder="Mileage">
                        </label>

                        <div class="btn-group w-100 pt-3 avenir-bold">
                            <button class="btn btn-outline-danger btn-outline-thick rounded-0" type="reset">Cancel <i class="fa fa-trash-o"></i></button>
                            <button class="btn btn-outline-primary btn-outline-thick rounded-0" type="submit">Save <i class="fa fa-floppy-o"></i></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <div id="car-cards" class="row col-12 col-md-8 col no-gutters align-content-start">
{{--            Cards are injected through Javascript           --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dealer.js') }}"></script>
@endsection
