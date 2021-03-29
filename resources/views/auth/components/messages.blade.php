@if (session('status'))
    <div class="status-container" role="alert">
        <span class="status-item my-1 px-4 py-1">
            {{ session('status') }}
        </span>
    </div>
@endif

@if ($errors->any())
    <div class="error-container">
        @foreach($errors->all() as $message)
            <span class="error-item my-1 px-4 py-1">{{ $message }}</span>
        @endforeach
    </div>
@endif
