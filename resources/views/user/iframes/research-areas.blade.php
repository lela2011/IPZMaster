@if ($researchAreas->isNotEmpty())
    <x-iframe-layout>
        <h2 class="TextImage--title  richtext">{{ $title }}</h2>
        <div class="TextImage--inner">
            <div class="TextImage--content richtext">
                <p>
                    @foreach ($researchAreas as $researchArea)
                        <a href="{{$researchArea['url']}}" target="_blank">{{ $researchArea['name'] }}</a>
                        @if(!$loop->last)
                            <br>
                        @endif
                    @endforeach
                </p>
            </div>
        </div>
    </x-iframe-layout>
@endif
