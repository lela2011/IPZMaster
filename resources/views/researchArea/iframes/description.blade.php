@if($description)
    <x-iframe-layout>
        <div class="TextImage--inner">
            <div class="TextImage--content richtext">
                {!! $description !!}
            </div>
        </div>
    </x-iframe-layout>
@endif
