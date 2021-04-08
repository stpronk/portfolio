{{--@dd($expensesByMonth)--}}

<div class="col-12 col-lg-9 mb-4 mb-lg-0">
    <div class="card rounded-0 border-0">
        <div class="card-header d-flex bg-light text-dark border-bottom border-primary rounded-0">
            <span class="flex-fill m-auto">
                Expenses
            </span>

            <div class="search mr-3">
                <input class="form-control" wire:model.debounse.500ms="search" placeholder="Enter to search...">
            </div>

            <div class="btn-wrapper m-auto">
                @if(!$new)
                    <button class="btn btn-link btn-sm" wire:click="toggleCreate()"><i class="fa fa-plus m-auto"></i></button>
                @else
                    <button class="btn btn-link btn-sm" wire:click="toggleCreate()"><i class="fa fa-ban m-auto"></i></button>
                @endif
            </div>
        </div>

        {{-- All expenses --}}
        @include('livewire.finance.components.expenses.list', [
            'expenses' => $expenses
        ])
    </div>

    @if ($delete)
        <div class="modal fade show d-block bg-black-50" id="delete-expense" tabindex="-1" role="dialog">
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
                                Deleting: <span class="text-danger">{{ $selectedExpense ? $selectedExpense['name'] : null }}.</span>
                                <br/>
                                <small>There is no way to reverse this process at the moment.</small>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" wire:click="delete()" data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-secondary" wire:click="cancelDelete()">No</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
