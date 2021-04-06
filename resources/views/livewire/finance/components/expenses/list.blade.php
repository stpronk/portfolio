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
