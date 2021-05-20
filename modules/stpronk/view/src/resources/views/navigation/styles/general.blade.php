@foreach ($navigation as $key => $item)
    <a class="btn btn-light px-2 mx-2 d-flex align-items-center rounded-0{{ $item->isActive ? ' ' : '' }}{{ $item->hasSubMenu ? ' dropdown-toggle' : ''}}"
       href="{{ $item->hasSubMenu ? "#{$item->slug}" : $item->url }}"
       @if ($item->hasSubMenu)
            data-toggle="dropdown"
       @endif
    >
        <span class="pl-1{{ !$item->hasSubMenu ? ' pr-1' : '' }}">{{ __($item->title) }}</span>
        @if (!$item->hasSubMenu)
            <i class="fa fa-{{ $item->icon }} pb-1"></i>
        @endif
    </a>

    @if($item->hasSubMenu)
        <div class="dropdown-menu">
            @foreach($item->subMenu as $key => $item)
                <a class="btn btn-light rounded-0 d-flex justify-content-between align-items-center px-2" href="{{ $item->url }}">
                    <span>{{ __($item->title) }}</span>
                    <i class="fa fa-{{ $item->icon }} pb-1"></i>
                </a>
            @endforeach
        </div>
    @endif
@endforeach
