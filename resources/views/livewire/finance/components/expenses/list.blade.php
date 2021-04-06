<div id="expenses-accordion" class="card-body mb-0 p-0 table-checkered">
    {{-- New expense form --}}
    @if($new)
        @include('livewire.finance.components.expenses.create')
    @endif

    @forelse( $expenses as $key => $expense )
       @include('livewire.finance.components.expenses.list-item', [
           'key'     => $key,
           'expense' => $expense
       ])
    @empty
        <div class="w-100 text-center text-size__large p-3">
            There are no expenses yet!
        </div>
    @endforelse
</div>
