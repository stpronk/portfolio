<div class="form-group">

    <label for="category" class="form-check-label d-flex mb-2">
        <span class="flex-fill">Category</span>
        @if( !$new )
            <button class="btn btn-success btn-sm" wire:click="new">New <i class="fa fa-plus"></i></button>
        @else
            <button class="btn btn-danger btn-sm" wire:click="new">Cancel <i class="fa fa-ban"></i></button>
        @endif
    </label>

    <hr />

    @if ($new === true)

        <form wire:submit.prevent>
            <div class="form-group">
                <label class="form-check-label" for="name">Name</label>
                <input id="name" class="form-control" type="text" wire:model="values.name">
            </div>

            <div class="form-group">
                <label class="form-check-label" for="color">Color</label>
                <input id="color" class="form-control" type="text" wire:model="values.color">
            </div>

            <button class="btn btn-success btn-block mt-4" type="button" wire:click="create">
                Save <i class="fa fa-floppy-o"></i>
            </button>
        </form>

    @else

        <select id="category" wire:model.lazy="selected" wire:change="prepareUpdate" class="form-control" style="background-color: {{ $selected !== '' ? $selectedCategory['color'] : ''}}">
            <option value="" selected>Select...</option>
            @foreach ($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
            @endforeach
        </select>

        @if ($update)
            <hr />
            <form wire:submit.prevent>
                <div class="form-group">
                    <label for="name" class="form-check-label">Name</label>
                    <input id="name" class="form-control" type="text" wire:model="values.name">
                </div>

                <div class="form-group">
                    <label for="color" class="form-check-label">Color</label>
                    <input id="color" class="form-control" type="text" wire:model="values.color">
                </div>

                <button class="btn btn-success btn-block mt-3" type="button" wire:click="update">
                    Save <i class="fa fa-floppy-o"></i>
                </button>

                <button class="btn btn-danger btn-block mt-3" type="button"
                        data-toggle="modal"
                        data-target="#delete-category">
                    Delete <i class="fa fa-trash"></i>
                </button>

                <button class="btn btn-info btn-block mt-3" type="button" wire:click="cancelUpdate">
                    Cancel <i class="fa fa-ban"></i>
                </button>
            </form>

            <div class="modal fade" id="delete-category" tabindex="-1" role="dialog">
                <form wire:submit.prevent>
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Are you sure?</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>This process is currently not reversible and all your data will be lost.</p>
                                <p>Deleting: <span class="text-danger">{{ $selectedCategory['name'] }}</span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" wire:click="delete" data-dismiss="modal">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif

    @endif
</div>
