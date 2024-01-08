@if ($orcid)
    <x-iframe-layout>
        <h2 class="TextImage--title  richtext">ORCID</h2>
        <div class="TextImage--inner">
            <div class="TextImage--content richtext">
                <a href="https://orcid.org/{{ $orcid }}" target="_blank">ORCID</a>
            </div>
        </div>
    </x-iframe-layout>
@endif
