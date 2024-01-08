@if ($transversalResearchPrios->isNotEmpty())
<x-iframe-layout>
    <h2 class="TextImage--title  richtext">{{ $title }}</h2>
    <div class="TextImage--inner">
        <div class="TextImage--content richtext">
            <ul>
                @foreach ($transversalResearchPrios as $prio)
                    <li>{{ $prio }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-iframe-layout>
@endif
