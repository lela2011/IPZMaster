@if ($cv)
    <x-iframe-layout>
        <h2 class="TextImage--title  richtext">Curriculum vitae</h2>
        <div class="TextImage--inner">
            <div class="TextImage--content richtext">
                {!! $cv !!}
            </div>
        </div>
    </x-iframe-layout>
@endif
