<div class="table-checkered__row d-flex flex-row px-3 pt-2 pb-1"
     style="border-left: 7px solid {{ $category['color'] ?? 'rgba(0,0,0,0)' }}"
     data-toggle="collapse" data-target="#category-collapse-{{$key}}" aria-controls="expense-collapse-{{$key}}"
>
    <div class="flex-fill">
        <span class="d-block text-size__normal">{{ $category['name'] }}</span>
    </div>
    <div class="m-auto text-right pr-2">
        <span class="d-block text-size__small">{{ $category['expenses_count'] }}</span>
    </div>
</div>

<div id="category-collapse-{{$key}}" class="collapse table-checkered__collapse{{ $selected === $category['id'] ? ' show' : '' }}" data-parent="#categories-accordion">
    <div class="d-flex flex-row w-100 justify-content-between">

        @if(( $selectedCategory['id'] ?? '' ) === $category['id'] && $update)
            @include('livewire.finance.components.categories.update')
        @else
            <div class="flex-fill d-flex flex-column w-100 text-size__small px-3 py-2">
                <div class="d-flex flex-column w-100 pb-2 mb-2 border-bottom justify-content-between">
                    <span class="pr-4">Color </span>
                    <span class="text-right">{{ $category['color'] ?? '-' }}</span>
                </div>
                <div class="d-flex flex-column w-100 pb-2 mb-2 border-bottom justify-content-between">
                    <span class="pr-4 text-nowrap">Created at </span>
                    <span class="text-right">{{ \Carbon\Carbon::create($category['created_at'])->format('Y-m-d H:i:s') }}</span>
                </div>
                <div class="d-flex flex-column w-100 justify-content-between">
                    <span class="pr-4 text-nowrap">Updated at </span>
                    <span class="text-right">{{ \Carbon\Carbon::create($category['updated_at'])->format('Y-m-d H:i:s') }}</span>
                </div>

                <div class="d-flex flex-row justify-content-end mt-2 pt-2 border-top">
                    <a class="btn btn-link" wire:click="prepareUpdate({{ $category['id'] }})"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-link" wire:click="prepareDelete({{ $category['id'] }})"><i class="fa fa-trash"></i></a>
                </div>
            </div>
        @endif
    </div>

</div>
