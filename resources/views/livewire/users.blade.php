<div class="card" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">Users</div>

    <div class="card-body">

        <div class="row">
            <div class="col-6">

                <div class="input-group">
                    <input wire:model="search"
                           name="search"
                           type="text"
                           placeholder="Search..."
                           class="form-control mb-3">
                    <div class="input-group-append">
                        <button wire:click="resetSearch"
                                class="btn btn-secondary form-control input-group-text">
                            Reset
                        </button>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td align="right">
                                    <div class="btn-group">
                                        <button wire:click="edit({{ $user->id }})" class="btn btn-info btn-sm text-white">
                                            <i class="fa fa-pencil"></i>
                                        </button>

                                        @if(Auth::user()->id !== $user->id)
                                            <button wire:click="delete({{ $user->id }})" class="btn btn-danger btn-sm text-white">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr style="text-align: center">
                                <td colspan="4">Not records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
            <div class="col-6">
                <form wire:submit.prevent="persist">

                    <div class="form-group">
                        <label class="form-check-label w-100">Name:
                            <input wire:model.lazy="new.name"
                                   type="text"
                                   class="form-control @error('new.name') is-invalid @enderror"
                                   autocomplete="false">
                            @error('new.name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-check-label w-100">E-mail:
                            <input wire:model.lazy="new.email"
                                   type="email"
                                   class="form-control @error('new.email') is-invalid @enderror"
                                   autocomplete="false">
                            @error('new.email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-check-label w-100">Password:
                            <input wire:model.lazy="new.password"
                                   type="password"
                                   class="form-control @error('new.password') is-invalid @enderror"
                                   autocomplete="false">
                            @error('new.password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                    </div>

                    <div class="btn-group w-100">
                        <button class="btn btn-info text-white" type="submit">Submit</button>
                        <button class="btn btn-secondary" type="button" wire:click="resetForm">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
