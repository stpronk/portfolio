<div class="d-flex flex-column w-100 px-2 py-3 border-bottom border-primary">
    <div class="d-flex flex-row w-100">
        <div class="d-flex flex-column w-100 px-2">
            <div class="form-group">
                <label for="date" class="form-check-label">Date</label>
                <input id="date" type="date" class="form-control" wire:model.defer="values.date" placeholder="...">
            </div>

            <div class="form-group">
                <label for="name" class="form-check-label">Name</label>
                <input id="name" type="text" class="form-control" wire:model.defer="values.name" placeholder="...">
            </div>

            <div class="form-group">
                <label for="amount" class="form-check-label">Amount</label>
                <input id="amount" type="number" min="0" step="0.01" class="form-control" wire:model.defer="values.amount" placeholder="...">
            </div>
        </div>

        <div class="d-flex flex-column w-100 px-1">
            <div class="form-group">
                <label for="type" class="form-check-label">Type</label>
                <select id="type" wire:model.defer="values.type" class="form-control">
                    @foreach (\App\Models\Finance\Expense::$TYPES as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id" class="form-check-label">Category</label>
                <select id="category_id" class="form-control" wire:model.defer="values.finance_category_id">
                    <option value="" checked>None</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="notes" class="form-check-label">Notes</label>
                <input id="notes" type="text" class="form-control" wire:model.defer="values.notes" placeholder="...">
            </div>
        </div>
    </div>

    <div class="d-flex px-2 justify-content-end">
        <div class="btn-group btn-group">
            <button class="btn btn-success" wire:click="update()"><i class="fa fa-floppy-o"></i></button>
            <button class="btn btn-danger" wire:click="cancelUpdate()"><i class="fa fa-ban"></i></button>
        </div>
    </div>
</div>