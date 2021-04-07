<div class="d-flex flex-column w-100 px-2 py-3 border-bottom border-primary">

    @include('livewire.finance.components.expenses.form')

    <div class="d-flex px-2 justify-content-between">
        <div class="fancy-checkbox d-flex">
            <input id="keep" name="keep" type="checkbox" class="input-checkbox" wire:model.defer="keep" tabindex="-1" />
            <label for="keep" class="form-check-label pl-1">
                Keep adding?
            </label>
        </div>
        <div class="btn-group btn-group">
            <button class="btn btn-link" wire:click="create()"><i class="fa fa-floppy-o"></i></button>
            <button class="btn btn-link" wire:click="toggleCreate()"><i class="fa fa-ban"></i></button>
        </div>
    </div>
</div>
