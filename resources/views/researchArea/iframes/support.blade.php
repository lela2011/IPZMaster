@if($support)
    <x-iframe-layout>
        <h2 class="TextImage--title  richtext">{{ $title }}</h2>
        <div class="TextImage--inner">
            <div class="TextImage--content richtext">
                {!! $support !!}
            </div>
        </div>
    </x-iframe-layout>
@endif
