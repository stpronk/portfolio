<nav class="d-block flex-fill">
    <div class="list-unstyled overflow-auto">
        @foreach($navigation as $key => $item)

            <a class="btn btn-secondary text-light rounded-0 d-flex justify-content-between align-items-center px-4 list-item
                {{ $item['active'] ? ' --active' : '' }}
                {{ $item['sub-active'] ? '' : ' collapsed' }}"
               href="{{ $item['has-sub'] ? "#{$item['title']}" : $item['route'] }}"

               @if ($item['has-sub'])
                   data-toggle="collapse"
                   role="button"
                   aria-controls="{{ $item['title'] }}"
               @endif
            >
                <span class="pl-1{{ $item['has-sub'] ? ' caret' : '' }}">
                    {{ __($item['title']) }}
                </span>
                <i class="fa fa-{{ $item['icon'] }} pb-1"></i>
            </a>

            @if($item['has-sub'])
                <div class="collapse{{ $item['sub-active'] ? ' show' : '' }}" id="{{ $item['title'] }}">
                    @foreach($item['sub-menu'] as $key => $item)
                        <a class="btn btn-secondary text-light rounded-0 d-flex justify-content-between align-items-center px-4 list-item{{ $item['active'] ? ' --active' : '' }}" href="{{ $item['route'] }}">
                            <span><i class="fa fa-angle-right px-1"></i> {{ __($item['title']) }}</span>
                            <i class="fa fa-{{ $item['icon'] }} pb-1"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
</nav>
