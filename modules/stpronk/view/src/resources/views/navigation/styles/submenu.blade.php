@foreach($navigation as $key => $item)
    <a class="btn text-white text-capetilize rounded-0 p-2 mx-2 avenir{{ $item['active'] ? ' top--active' : '' }}" href="{{ $item['route'] }}">{{ $item['title'] }} <i class="fa fa-{{ $item['icon'] }}{{ $item['title'] !== '' ? ' ml-2' : '' }}"></i></a>
@endforeach
