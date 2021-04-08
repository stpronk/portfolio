<div class="d-flex flex-column w-100 px-2">
    <div class="form-group">
        <label for="name" class="form-check-label">Name</label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="values.name" placeholder="..." autofocus>
        @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="color" class="form-check-label">Color</label>
        <input id="color" type="color" class="form-control @error('color') is-invalid @enderror" wire:model.defer="values.color" placeholder="...">
        @error('color')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
