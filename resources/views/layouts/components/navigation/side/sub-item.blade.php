<a class="btn btn-secondary text-light rounded-0 d-flex justify-content-between align-items-center px-4 list-item{{ $item['route'] === url()->current() ? ' --active' : '' }}" href="{{ $item['route'] }}">
    <span><i class="fa fa-angle-right px-1"></i> {{ __($item['title']) }}</span>
    <i class="fa fa-{{ $item['icon'] }} pb-1"></i>
</a>
