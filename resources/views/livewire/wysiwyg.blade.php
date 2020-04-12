<form wire:submit.prevent>
    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

{{--  TODO: Should make buttons to let this work better  --}}
{{--    <div class="btn-group">--}}
{{--        <button class="btn btn-outline-secondary"><i class="fa fa-bold"></i></button>--}}
{{--        <button class="btn btn-outline-secondary"><i class="fa fa-italic"></i></button>--}}
{{--        <button class="btn btn-outline-secondary"><i class="fa fa-underline"></i></button>--}}
{{--        <button class="btn btn-outline-secondary"><i class="fa fa-strikethrough"></i></button>--}}
{{--    </div>--}}

    @foreach($fields as $field => $value)
        <div class="form-group">
            <label class="form-check-label">{{ ucfirst($field) }}:</label>
            <div class="form-control h-auto" contenteditable="true" data-field="{{ $field }}">{!!$value ?? '' !!}</div>
        </div>
    @endforeach

    <button type="submit" class="btn btn-info text-white">Save</button>

        @dump($fields)

    <script>
        document.querySelector('[type=submit]').addEventListener('click', (event) => {
            const html = event.target.closest('form');
            const component = window.livewire.find(html.getAttribute('wire:id'));

            html.querySelectorAll('[data-field]').forEach((element) => {
              component.set(`fields.${element.getAttribute('data-field')}`, element.innerHTML);
            });

            component.call('persist');
        })
    </script>
</form>
