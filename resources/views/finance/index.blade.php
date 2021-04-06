@extends('layouts.app')

@section('content')
    <div class="card rounded-0 border-0">
        <div class="card-header d-flex flex-row bg-light text-dark border-bottom border-primary rounded-0">
            <div class="flex-fill">
                Finance Groups
            </div>
            <div class="flex">
                <button class="btn btn-success btn-sm text-white" data-toggle="modal" data-target="#create-group"><i class="fa fa-plus"></i> Add new</button>
            </div>
        </div>
        <table class="card-body table mb-0">
            <tbody>
                @forelse ($groups as $group)
                    <tr class="d-flex flex-row">
                        <td class="flex-fill">
                            <a href="{{ route('finance.group', ['group' => $group->id]) }}">
                                {{ $group->name }}
                            </a>
                        </td>
                        <td class="btn-group">
                            <a href="{{ route('finance.group', ['group' => $group->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-sign-in"></i></a>
                            <a href="#" class="btn btn-info btn-sm text-white disabled"><i class="fa fa-cog"></i></a>
                            <button type="button" class="btn btn-danger btn-sm"
                                    data-toggle="modal"
                                    data-target="#delete-group"
                                    data-group-id="{{ $group->id }}"
                                    data-group-name="{{ $group->name }}"
                            ><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="">Create your first group!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Create a Group modal --}}
    <div class="modal fade" id="create-group" tabindex="-1" role="dialog">
        <form method="post" action="{{ route('finance.group.create') }}">
            @csrf
            @method('POST')
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Create new group</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="owner_id" value="{{ \Illuminate\Support\Facades\Auth::id() }}">

                        <div class="form-group">
                            <label class="form-check-label" for="name">Name: </label>
                            <input type="text" id="name" name="name" class="form-control" value="" placeholder="...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Delete a Group modal --}}
    <div class="modal fade" id="delete-group" tabindex="-1" role="dialog">
        <form method="post" action="{{ route('finance.group.delete') }}">
            @csrf
            @method('DELETE')
            <input id="group-id" type="hidden" name="group_id" value="0">

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
                        <p>Deleting: <span id="group-name" class="text-danger"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        {{-- Add correct information when deleting a group --}}
        document.querySelectorAll('[data-target="#delete-group"]').forEach(function (element) {
            element.addEventListener('click', function (event) {
                document.getElementById('group-id').value = event.currentTarget.getAttribute('data-group-id');
                document.getElementById('group-name').innerHTML = event.currentTarget.getAttribute('data-group-name');
            });
        })
    </script>
@stop
