<div id="expenses-accordion" class="card-body mb-0 p-0">
    {{-- New expense form --}}
    @if($new)
        @include('livewire.finance.components.expenses.create')
    @endif

{{--    TODO: Should be kept for the time being --}}
{{--    @forelse( $expenses as $key => $expense )--}}
{{--       @include('livewire.finance.components.expenses.list-item', [--}}
{{--           'key'     => $key,--}}
{{--           'expense' => $expense--}}
{{--       ])--}}
{{--    @empty--}}
{{--        <div class="w-100 text-center text-size__large p-3">--}}
{{--            There are no expenses yet!--}}
{{--        </div>--}}
{{--    @endforelse--}}

    @forelse( $expensesByMonth as $date => $expenses )
        @if(!$loop->first)
            <div class="spacer mt-3"></div>
        @endif

        <div class="d-flex flex-row px-4 pt-2 pb-1 bg-light-gradient">
            <div class="flex-fill">
                <span class="d-block text-size__normal avenir-medium text-secondary">{{ \Carbon\Carbon::parse($date)->format('F Y') }}</span>
            </div>
        </div>

        <div class="table-checkered">
            @foreach($expenses as $key => $expense)
                @include('livewire.finance.components.expenses.list-item', [
                    'key'     => $date.$key,
                    'expense' => $expense
                ])
            @endforeach
        </div>

    @empty
        <div class="w-100 text-center text-size__large p-3">
            There are no expenses yet!
        </div>
    @endforelse
</div>
