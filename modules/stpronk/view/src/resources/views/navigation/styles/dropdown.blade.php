@foreach($navigation as $key => $item)
    <a class="btn btn-light rounded-0 d-flex justify-content-between align-items-center px-2" href="{{ $item->url }}">
        <span>{{ __($item->title) }}</span>
        <i class="fa fa-{{ $item->icon }} pb-1 pr-1"></i>
    </a>
@endforeach
