<div class="d-flex flex-row w-100">
    <div class="d-flex flex-column w-100 px-2">
        <div class="form-group">
            <label for="date" class="form-check-label">Date</label>
            <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" wire:model.defer="values.date" placeholder="..." autofocus>
            @error('date')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="name" class="form-check-label">Name</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="values.name" placeholder="...">
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="amount" class="form-check-label">Amount</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">€</span>
                </div>
                <input id="amount" type="number" min="0" step="0.01" class="form-control @error('amount') is-invalid @enderror" wire:model.defer="values.amount" placeholder="...">
            </div>
            @error('amount')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="d-flex flex-column w-100 px-1">
        <div class="form-group">
            <label for="type" class="form-check-label">Type</label>
            <select id="type" wire:model.defer="values.type" class="form-control @error('type') is-invalid @enderror">
                @foreach (\App\Models\Finance\Expense::$TYPES as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
            @error('type')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id" class="form-check-label">Category</label>
            <select id="category_id" class="form-control @error('finance_category_id') is-invalid @enderror" wire:model.defer="values.finance_category_id">
                <option value="" checked>None</option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
            @error('finance_category_id')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="notes" class="form-check-label">Notes</label>
            <input id="notes" type="text" class="form-control @error('notes') is-invalid @enderror" wire:model.defer="values.notes" placeholder="...">
            @error('notes')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
