<div class="col-12 col-lg-9 mb-4 mb-lg-0">
    <div class="card">
        <div class="card-header">
            Expenses
        </div>
        <table class="card-body table mb-0">
            <thead>
                <tr>
                    <th style="min-width: 150px">Date</th>
                    <th style="min-width: 150px">Name</th>
                    <th style="min-width: 150px">Amount</th>
                    <th style="min-width: 150px">Type</th>
                    <th style="min-width: 150px">Category</th>
                    <th style="min-width: 120px">Notes</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse( $expenses as $expense )
                    <tr style="background-color: {{ $expense['category']['color'] ?? '' }}">

                        @if($update && $selectedExpense['id'] === $expense['id'])
                            <td>
                                <input type="date" class="form-control" wire:model.defer="values.date" placeholder="date...">
                            </td>
                            <td>
                                <input type="string" class="form-control" wire:model.defer="values.name" placeholder="name...">
                            </td>
                            <td>
                                <input type="number" min="0" step="0.01" class="form-control" wire:model.defer="values.amount" placeholder="amount...">
                            </td>
                            <td>
                                <select wire:model.defer="values.type" class="form-control">
                                    @foreach (\App\Models\Finance\Expense::$TYPES as $type)
                                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control" wire:model.defer="values.finance_category_id">
                                    <option value="" checked>None</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="string" class="form-control" wire:model.defer="values.notes" placeholder="Note..">
                            </td>
                            <td class="text-right btn-group btn-group-sm">
                                <button class="btn btn-danger btn-outline-light" wire:click="cancelUpdate()"><i class="fa fa-ban"></i></button>
                                <button class="btn btn-success btn-outline-light" wire:click="update()"><i class="fa fa-floppy-o"></i></button>
                            </td>
                        @else
                            <td>{{ $expense['date'] }}</td>
                            <td>{{ $expense['name'] }}</td>
                            <td>{{ $expense['amount'] }}</td>
                            <td>{{ ucfirst($expense['type']) }}</td>
                            <td>{{ $expense['category']['name'] ?? '-' }}</td>
                            <td>{{ $expense['notes'] ?? '-' }}</td>
                            <td class="btn-group btn-group-sm border-top-1">
                                <button class="btn btn-primary btn-outline-light" wire:click="prepareUpdate({{ $expense['id'] }})"><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-danger btn-outline-light"><i class="fa fa-trash"></i></button>
                            </td>
                        @endif

                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6">There are no expenses yet!</td>
                    </tr>
                @endforelse

                @if($new)
                    <tr>
                        <td>
                            <input type="date" class="form-control" wire:model.defer="values.date" placeholder="date...">
                        </td>
                        <td>
                            <input type="string" class="form-control" wire:model.defer="values.name" placeholder="name...">
                        </td>
                        <td>
                            <input type="number" min="0" step="0.01" class="form-control" wire:model.defer="values.amount" placeholder="amount...">
                        </td>
                        <td>
                            <select wire:model.defer="values.type" class="form-control">
                                @foreach (\App\Models\Finance\Expense::$TYPES as $type)
                                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" wire:model.defer="values.finance_category_id">
                                <option value="" checked>None</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="string" class="form-control" wire:model.defer="values.notes" placeholder="Note..">
                        </td>
                        <td class="text-right">
                            <button class="btn btn-success" wire:click="create()"><i class="fa fa-floppy-o"></i></button>
                        </td>
                    </tr>
                @endif()

                <tr>
                    <td colspan="7">
                        @if($new)
                            <button class="btn btn-danger" wire:click="toggleCreate()">Cancel <i class="fa fa-ban"></i></button>
                        @else
                            <button class="btn btn-success" wire:click="toggleCreate()">Add <i class="fa fa-plus"></i></button>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
