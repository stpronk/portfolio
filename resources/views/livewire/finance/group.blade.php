<div class="row">
    <div class="col-12 mb-4">
        <div class="card rounded-0 border-0">
            <div class="card-header d-flex bg-light text-dark border-bottom border-primary rounded-0">
                <h5 class="flex-fill px-1 pt-2"><i class="fa fa-money"></i> {{ $group->name }}</h5>
            </div>
            <div class="card-body">
                work in progress...
            </div>
        </div>
    </div>

    <livewire:finance.expenses :group="$group" />
    <livewire:finance.categories :group="$group"/>
</div>
