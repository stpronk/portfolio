@foreach ($navigation as $key => $item)
    <a class="btn btn-light px-2 mx-2 d-flex align-items-center rounded-0{{ $item['active'] ? ' ' : '' }}{{ $item['has-sub'] ? ' dropdown-toggle' : ''}}"
       href="{{ $item['has-sub'] ? "#{$item['title']}" : $item['route'] }}"
       @if ($item['has-sub'])
            data-toggle="dropdown"
       @endif
    >
        <span class="pl-1{{ !$item['has-sub'] ? ' pr-1' : '' }}">{{ __($item['title']) }}</span>
        @if (!$item['has-sub'])
            <i class="fa fa-{{ $item['icon'] }} pb-1"></i>
        @endif
    </a>

    @if($item['has-sub'])
        <div class="dropdown-menu">
            @foreach($item['sub-menu'] as $key => $item)
                <a class="btn btn-light rounded-0 d-flex justify-content-between align-items-center px-2" href="{{ $item['route'] }}">
                    <span>{{ __($item['title']) }}</span>
                    <i class="fa fa-{{ $item['icon'] }} pb-1"></i>
                </a>
            @endforeach
        </div>
    @endif
@endforeach
