<div class="col-12 col-md-4 col-lg-3">
    <div class="card">
        <div class="card-header d-flex">
            <span class="flex-fill">Category</span>
            <div class="btn-group">
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#new-category"><i class="fa fa-plus"></i></button>
                @if($settings)
                    <button class="btn btn-danger btn-sm" wire:click="toggleSettings()"><i class="fa fa-ban"></i></button>
                @else
                    <button class="btn btn-primary btn-sm" wire:click="toggleSettings()"><i class="fa fa-cog"></i></button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">

                <!-- TODO: Checkboxes were made to filter the expenses, this still needs to be implemented -->

                <!-- All the categories that are within the group  -->
                <table class="col-12 table">
                    @foreach($categories as $category)
                        <tr class="d-flex" style="background-color: {{ $category['color'] }}" >
                            <td class="form-check flex-fill">
                                @if(!$settings)
                                    <input id="{{ $category['name'] }}-{{ $category['id'] }}" type="checkbox" value="{{ $category['id'] }}" class="form-check-input" checked>
                                @endif
                                <label for="{{ $category['name'] }}-{{ $category['id'] }}" class="form-check-label">({{ $category['expenses_count'] }}) {{ $category['name'] }}</label>
                            </td>
                            @if($settings)
                                <td class="btn-group">
                                    <button class="btn btn-sm btn-primary btn-outline-light" wire:click="prepareUpdate({{ $category['id'] }})"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-sm btn-danger btn-outline-light" wire:click="prepareDelete({{ $category['id'] }})"><i class="fa fa-trash"></i></button>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                    @if(!$settings)
                        <tr>
                            <td class="form-check">
                                <!-- TODO: Checkbox should automatically turn check and uncheck when the rest are all checked or when one is not checked -->
                                <!-- TODO: Checkbox should check or uncheck all other checkboxes -->
                                <input id="all-0" type="checkbox" value="" class="form-check-input" checked>
                                <label for="all-0" class="form-check-label">All</label>
                            </td>
                        </tr>
                    @endif
                </table>

            </div>
        </div>
    </div>

{{--    @dd($selectedCategory)--}}


    {{-- MODALS --}}

    <div class="modal fade" id="new-category" tabindex="-1" role="dialog">
        <form wire:submit.prevent>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create new Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-check-label">Name</label>
                            <input id="name" class="form-control" type="text" wire:model.defer="values.name">
                        </div>

                        <div class="form-group">
                            <label for="color" class="form-check-label">Color</label>
                            <input id="color" class="form-control" type="text" wire:model.defer="values.color">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" data-dismiss="modal" wire:click="create()">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if ($update)
        <div class="modal fade show d-block bg-black-50" id="update-category" tabindex="-1" role="dialog">
            <form wire:submit.prevent>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update {{ $selectedCategory ? $selectedCategory['name'] : 'Null' }}</h5>
                            <button type="button" class="close" aria-label="Close" wire:click="cancelUpdate()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="form-check-label">Name</label>
                                <input id="name" class="form-control" type="text" wire:model.defer="values.name">
                            </div>

                            <div class="form-group">
                                <label for="color" class="form-check-label">Color</label>
                                <input id="color" class="form-control" type="text" wire:model.defer="values.color">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" wire:click="update()">Create</button>
                            <button type="button" class="btn btn-secondary" wire:click="cancelUpdate()">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if($delete)
        <div class="modal fade show d-block bg-black-50" id="delete-category" tabindex="-1" role="dialog">
            <form wire:submit.prevent>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Are you sure?</h5>
                            <button type="button" class="close text-white" aria-label="Close" wire:click="cancelDelete()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>This process is currently not reversible and all your data will be lost.</p>
                            <p>
                                Deleting: <span class="text-danger">{{ $selectedCategory ? $selectedCategory['name'] : null }} with {{ $selectedCategory ?  $selectedCategory['expenses_count'] : null }} attached Expenses.</span>
                                <br/>
                                <small>Attached expenses will be detached and will not be deleted</small>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" wire:click="delete" data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-secondary" wire:click="cancelDelete()">No</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
