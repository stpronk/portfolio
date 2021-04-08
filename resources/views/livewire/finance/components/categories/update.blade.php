<div class="d-flex flex-column w-100 px-2 py-2 border-bottom border-primary">

    @include('livewire.finance.components.categories.form')

    <div class="d-flex px-2 justify-content-end">
        <button class="btn btn-link mr-2" wire:click="update()"><i class="fa fa-floppy-o"></i></button>
        <button class="btn btn-link" wire:click="cancelUpdate()"><i class="fa fa-ban"></i></button>
    </div>
</div>
