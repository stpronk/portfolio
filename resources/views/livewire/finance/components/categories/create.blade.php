<div class="d-flex flex-column w-100 px-2 py-3 border-bottom border-primary">

    @include('livewire.finance.components.categories.form')

    <div class="d-flex px-2 justify-content-end">
        <div class="btn-group btn-group">
            <button class="btn btn-link" wire:click="create()"><i class="fa fa-floppy-o"></i></button>
        </div>
    </div>
</div>
