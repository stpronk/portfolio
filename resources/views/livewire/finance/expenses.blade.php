<div class="col-12 col-lg-9 mb-4 mb-lg-0">
    <div class="card rounded-0 border-0">
        <div class="card-header bg-light text-dark border-bottom border-primary rounded-0">
            Expenses
        </div>
        <div id="expenses-accordion" class="card-body mb-0 p-0 table-checkered">
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
