<div class="modal fade avenir" id="assignments" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-secondary-gradient rounded-0 pb-2">

            <div class="d-flex mt-4 px-4 text-light">
                <h1 class="h3 flex-fill avenir-bold text-uppercase">{{ __('Assignments') }}</h1>
                <a class="close text-white pointer" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            <div class="assignment-list text-white rounded-0 w-100">
                <a class="assignment-item d-flex text-white px-4 py-1 my-1" href="{{ route('assignment.dealer') }}">
                    <span class="flex-fill">Competa as Dealer</span>Javascript
                </a>
                <a class="assignment-item d-flex text-white px-4 py-1 my-1" href="{{ route('assignment.event-planner') }}">
                    <span class="flex-fill">Geo location event planner</span>Javascript
                </a>
            </div>

        </div>
    </div>
</div>
