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
        <div id="expenses-accordion" class="card-body mb-0 p-0 table-checkered">

            {{-- New expense form --}}
            @if($new)
                <div class="d-flex flex-column w-100 px-2 py-3 border-bottom border-primary">
                    <div class="d-flex flex-row w-100">
                        <div class="d-flex flex-column w-100 px-2">
                            <div class="form-group">
                                <label for="date" class="form-check-label">Date</label>
                                <input id="date" type="date" class="form-control" wire:model.defer="values.date" placeholder="date...">
                            </div>

                            <div class="form-group">
                                <label for="name" class="form-check-label">Name</label>
                                <input id="name" type="string" class="form-control" wire:model.defer="values.name" placeholder="name...">
                            </div>

                            <div class="form-group">
                                <label for="amount" class="form-check-label">Amount</label>
                                <input id="amount" type="number" min="0" step="0.01" class="form-control" wire:model.defer="values.amount" placeholder="amount...">
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
                                <input id="notes" type="string" class="form-control" wire:model.defer="values.notes" placeholder="Note..">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex px-2 justify-content-between">
                        <div class="fancy-checkbox d-flex">
                            <input id="keep" name="keep" type="checkbox" class="input-checkbox" wire:model.defer="keep" tabindex="-1" />
                            <label for="keep" class="form-check-label pl-1">
                                Keep adding?
                            </label>
                        </div>
                        <div class="btn-group btn-group">
                            <button class="btn btn-success" wire:click="create()"><i class="fa fa-floppy-o"></i></button>
                            <button class="btn btn-danger" wire:click="toggleCreate()"><i class="fa fa-ban"></i></button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- All expenses --}}
            @forelse( $expenses as $key => $expense )
                <div class="table-checkered__row d-flex flex-row px-3 pt-2 pb-1"
                     style="border-left: 7px solid {{ $expense['category'] ? $expense['category']['color'] : 'rgba(0,0,0,0)' }}"
                     data-toggle="collapse" data-target="#expense-collapse-{{$key}}" aria-controls="expense-collapse-{{$key}}"
                >
                    <div class="flex-fill">
                        <span class="d-block text-size__normal">{{ $expense['name'] }}</span>
                        <span class="d-block text-size__extra-small">{{ $expense['category'] ? $expense['category']['name'] : '-' }}</span>
                    </div>
                    <div class="m-auto text-right">
                        <span class="d-block text-size__normal {{ $expense['type'] === \App\Models\Finance\Expense::$TYPES[0] ? 'text-danger' : 'text-success' }}">{{ $expense['amount'] }}</span>
                        <span class="d-block text-muted text-size__extra-small">{{ $expense['date'] }}</span>
                    </div>
                </div>
                <div id="expense-collapse-{{$key}}" class="collapse table-checkered__collapse" data-parent="#expenses-accordion">
                    <div class="d-flex flex-row w-100 justify-content-between pl-4 pr-2 py-2">

                        <div class="flex-fill d-flex flex-column w-100 text-size__small">
                            <div class="d-flex flex-row w-100 pb-2 pr-1 justify-content-between">
                                <span class="pr-4">Notes </span>
                                <span>{{ $expense['notes'] ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-row w-100 justify-content-between">
                                <span class="pr-4">Created at </span>
                                <span>{{ \Carbon\Carbon::create($expense['created_at'])->format('Y-m-d H:i:s') }}</span>
                            </div>
                            <div class="d-flex flex-row w-1000 justify-content-between">
                                <span class="pr-4">Updated at </span>
                                <span>{{ \Carbon\Carbon::create($expense['updated_at'])->format('Y-m-d H:i:s') }}</span>
                            </div>
                        </div>

                        <div class="d-flex flex-row justify-content-end pl-2 ml-4 border-left">
                            <div class="btn-group btn-group-sm btn-group-vertical">
                                <button class="btn btn-link" wire:click="prepareUpdate({{ $expense['id'] }})"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-link"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>

                    </div>

                </div>
            @empty
                <div class="w-100 text-center text-size__large p-3">
                    There are no expenses yet!
                </div>
            @endforelse
        </div>
    </div>
</div>
