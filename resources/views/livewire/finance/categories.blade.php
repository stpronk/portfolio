<div class="col-12 col-lg-3">
    <div class="card border-0 rounded-0">
        <div class="card-header d-flex bg-light text-dark border-bottom border-primary rounded-0">
            <span class="flex-fill m-auto">Category</span>
            <div class="btn-wrapper">
                @if(!$new)
                    <button class="btn btn-link btn-sm" wire:click="toggleCreate()"><i class="fa fa-plus m-auto"></i></button>
                @else
                    <button class="btn btn-link btn-sm" wire:click="toggleCreate()"><i class="fa fa-ban m-auto"></i></button>
                @endif
            </div>
        </div>
        <div class="card-body p-0">
            @include('livewire.finance.components.categories.list', [
                'categories' => $categories
            ])
        </div>
    </div>

    @if($delete)
        <div class="modal fade show d-block bg-black-50" id="delete-category" tabindex="-1" role="dialog">
            <form wire:submit.prevent>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Are you sure?</h5>
                            <button type="button" class="close text-white" aria-label="Close" wire:click="cancelDelete()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>This process is currently not reversible and all your data will be lost.</p>
                            <p>
                                Deleting: <span class="text-danger">{{ $selectedCategory ? $selectedCategory['name'] : null }} with {{ $selectedCategory ?  $selectedCategory['expenses_count'] : null }} attached Expenses.</span>
                                <br/>
                                <small>Attached expenses will be detached and will not be deleted</small>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" wire:click="delete" data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-secondary" wire:click="cancelDelete()">No</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
