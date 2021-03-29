<nav class="d-block flex-fill">
    <div class="list-unstyled overflow-auto">
        @foreach($navigation as $key => $item)
            @include('layouts.components.navigation.side.item', [
                'key'  => $key,
                'item' => $item
            ])
        @endforeach
    </div>
</nav>
