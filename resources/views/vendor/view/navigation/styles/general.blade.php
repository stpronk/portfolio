<nav class="d-block flex-fill">
    <div class="list-unstyled overflow-auto">
        @foreach($navigation as $key => $item)

            <a class="btn btn-secondary text-light rounded-0 d-flex justify-content-between align-items-center px-4 list-item
                {{ $item->isActive() ? ' --active' : '' }}
                {{ $item->isSubActive() ? '' : ' collapsed' }}"
               href="{{ $item->hasSubMenu ? "#{$item->slug}" : $item->url }}"

               @if ($item->hasSubMenu)
                   data-toggle="collapse"
                   role="button"
                   aria-controls="{{ $item->title }}"
               @endif
            >
                <span class="pl-1{{ $item->hasSubMenu ? ' caret' : '' }}">
                    {{ __($item->title) }}
                </span>
                <i class="fa fa-{{ $item->icon }} pb-1"></i>
            </a>

            @if($item->hasSubMenu)
                <div class="collapse{{ $item->isSubActive() ? ' show' : '' }}" id="{{ $item->slug }}">
                    @foreach($item->subMenu as $key => $item)
                        <a class="btn btn-secondary text-light rounded-0 d-flex justify-content-between align-items-center px-4 list-item{{ $item->isActive() ? ' --active' : '' }}" href="{{ $item->url }}">
                            <span><i class="fa fa-angle-right px-1"></i> {{ __($item->title) }}</span>
                            <i class="fa fa-{{ $item->icon }} pb-1"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
</nav>
