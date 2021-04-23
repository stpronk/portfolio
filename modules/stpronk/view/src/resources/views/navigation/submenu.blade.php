<div class="w-100 bg-light shadow">
    @foreach($navigation as $key => $item)
        <a class="btn btn-light text-dark text-capetilize rounded-0 p-2 mx-2 avenir-bold{{ $item['active'] ? ' top--active' : '' }}" href="{{ $item['route'] }}">{{ $item['title'] }} <i class="ml-2 fa fa-{{ $item['icon'] }}"></i></a>
    @endforeach
</div>
