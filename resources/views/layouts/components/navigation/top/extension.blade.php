<div id="assignment-accordion" class="shadow">
    <div class="w-100 bg-primary">
        @foreach($data as $key => $item)
            <a class="btn btn-primary text-white text-capetilize rounded-0 p-1 mx-1 avenir"
               data-toggle="collapse" data-target="#collapse{{ $key }}" aria-controls="collapse{{ $key }}">
                    {{ $item['title'] }}
            </a>
        @endforeach
    </div>

    <div class="w-100 bg-light text-dark avenir overflow-auto" >
        @foreach($data as $key => $item)
            <div id="collapse{{ $key }}" class="collapse" data-parent="#assignment-accordion">
                <div class="border-top border-bottom border-primary">
                    <div class="px-3 pt-3 overflow-auto" style="max-height: 30vh">
                        <h2 class="avenir-bold">{{ $item['title'] }}</h2>
                        <hr/>
                        {!! $item['content'] !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
