<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex">
                <h5 class="flex-fill px-1 pt-2"><i class="fa fa-money"></i> {{ $group->name }}</h5>
            </div>
            <div class="card-body">
                work in progress...
            </div>
        </div>
    </div>

    <div class="col-12 col-md-8 col-lg-9 mb-4 mb-md-0">
        <div class="card">
            <div class="card-header">
                Expenses
            </div>
            <table class="card-body table mb-0">
                <livewire:finance.expenses :group="$group" />
            </table>
        </div>
    </div>

    <div class="col-12 col-md-4 col-lg-3">
        <div class="card">
            <div class="card-header">
                Categories
            </div>
            <div class="card-body">
                <livewire:finance.categories :group="$group"/>
            </div>
        </div>
    </div>
</div>
