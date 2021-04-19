<a class="btn btn-secondary text-light rounded-0 d-flex justify-content-between align-items-center px-4 list-item
        {{ $item['route'] === url()->current() || (( $item['sub-menu'] && isset($item['hide-sub-menu']) ) &&  \Illuminate\Support\Str::contains( url()->current(), $item['route']) ) || ( !$item['sub-menu'] && \Illuminate\Support\Str::contains( url()->current(), $item['route']) ) ? ' --active' : '' }}
        {{ $item['sub-menu'] && ( !\Illuminate\Support\Str::contains( url()->current(), $item['route']) ) ? ' collapsed' : '' }}"
   href="{{ ($item['sub-menu'] && !isset($item['hide-sub-menu'])) ? '#'.$item['title'] : $item['route'] }}"

    @if ($item['sub-menu'] && !isset($item['hide-sub-menu']))
        data-toggle="collapse"
        role="button"
        aria-controls="{{ $item['title'] }}"
    @endif
>
    <span class="pl-1{{ ($item['sub-menu'] && !isset($item['hide-sub-menu'])) ? ' caret' : '' }}">
        {{ __($item['title']) }}
    </span>
    <i class="fa fa-{{ $item['icon'] }} pb-1"></i>
</a>

@if($item['sub-menu'] && !isset($item['hide-sub-menu']))
    <div class="collapse {{ \Illuminate\Support\Str::contains( url()->current(), $item['route']) ? ' show' : '' }}" id="{{ $item['title'] }}">
        @foreach($item['sub-menu'] as $key => $item)
            @include('layouts.components.navigation.side.sub-item', [
                'key'  => $key,
                'item' => $item
            ])
        @endforeach
    </div>
@endif
