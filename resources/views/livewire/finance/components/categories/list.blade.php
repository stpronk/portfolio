<div id="categories-accordion" class="card-body mb-0 p-0 table-checkered">
    @if($new)
       @include('livewire.finance.components.categories.create')
    @endif

    @foreach($categories as $key => $category)
        @include('livewire.finance.components.categories.list-item', [
            'category' => $category,
            'key'      => $key
        ])
    @endforeach
</div>
