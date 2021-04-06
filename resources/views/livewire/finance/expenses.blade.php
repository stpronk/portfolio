<div class="col-12 col-lg-9 mb-4 mb-lg-0">
    <div class="card rounded-0 border-0">
        <div class="card-header d-flex bg-light text-dark border-bottom border-primary rounded-0">
            <span class="flex-fill m-auto">
                Expenses
            </span>

            <div class="btn-wrapper">
                @if(!$new)
                    <button class="btn btn-link btn-sm" wire:click="toggleCreate()"><i class="fa fa-plus m-auto"></i></button>
                @else
                    <button class="btn btn-link btn-sm" wire:click="toggleCreate()"><i class="fa fa-ban m-auto"></i></button>
                @endif
            </div>
        </div>

        {{-- All expenses --}}
        @include('livewire.finance.components.expenses.list', [
            'expenses' => $expenses,
            'selected' => $selected
        ])
    </div>
</div>
