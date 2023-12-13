<x-layout>
    <x-back>
        <x-slot:route>
            {{ route('research.index') }}
        </x-slot:route>
        Return to list
    </x-back>
    <div class="ContentArea">
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $research->title }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    @if ($research->title_original)
                        <h3>
                            {{ $research->title_original }}
                        </h3>
                    @endif
                    <p>
                        {{ \Carbon\Carbon::parse($research->start_date)->format('l, jS F Y') }} until {{ \Carbon\Carbon::parse($research->end_date)->format('l, jS F Y') }}
                    </p>
                    @if($research->summary)
                        <h4>
                            Summary:
                        </h4>
                        {!! $research->summary !!}
                    @endif
                    @if($research->summary_urls)
                        <h4>
                            Summary Links:
                        </h4>
                        @foreach ($research->summary_urls as $url)
                            <a href="{{ $url }}" target="_blank">
                                {{ parse_url($url)['host'] }}
                            </a><br>
                        @endforeach
                    @endif
                    @if ($research->fundings)
                        <h4>
                            Sources of Funding:
                        </h4>
                        <ul>
                            @foreach ($research->fundings as $funding)
                                <li>
                                    {{ $funding }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($research->institutions)
                        <h4>
                            Collaborating institutions:
                        </h4>
                        <ul>
                            @foreach ($research->institutions as $institution)
                                <li>
                                    {{ $institution }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($research->countrys)
                        <h4>
                            Collaborating Countries:
                        </h4>
                        <ul>
                            @foreach ($research->countrys as $country)
                                <li>
                                    {{ $country }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($research->zora_ids)
                        <h4>
                            ZORA:
                        </h4>
                        @foreach ($research->zora_ids as $zora_id)
                            <a href="https://www.zora.uzh.ch/id/eprint/{{ $zora_id }}" target="_blank">
                                {{ $zora_id }}
                            </a><br>
                        @endforeach
                    @endif
                    @if ($research->publication_url)
                        <h4>
                            Published in:
                        </h4>
                        <a href="{{ $research->publication_url }}" target="_blank">
                            {{ parse_url($research->publication_url)['host'] }}
                        </a>
                    @endif
                    @if ($research->project_urls)
                        <h4>
                            External Resources:
                        </h4>
                        @foreach ($research->project_urls as $url)
                            <a href="{{ $url }}" target="_blank">
                                {{ parse_url($url)['host'] }}
                            </a><br>
                        @endforeach
                    @endif
                    @if($research->internalContacts->isNotEmpty() || $research->externalContacts->isNotEmpty())
                        <h4>
                            Contacts:
                        </h4>
                        @if($research->internalContacts->isNotEmpty())
                            <h5>
                                Internal:
                            </h5>
                            @foreach ($research->internalContacts as $contact)
                                <a href="mailto:{{ $contact->email }}" target="_blank">
                                    {{ $contact->first_name }} {{ $contact->last_name }}
                                </a>
                                <br>
                            @endforeach
                        @endif
                        @if($research->externalContacts->isNotEmpty())
                            <h5>
                                External:
                            </h5>
                            @foreach ($research->externalContacts as $contact)
                                <a href="mailto:{{ $contact->email }}">
                                    {{ $contact->name }}
                                </a>
                                <br>
                            @endforeach
                        @endif
                    @endif
                    @if ($research->researchAreas->isNotEmpty())
                        <h4>
                            Research Areas:
                        </h4>
                        <ul>
                            @foreach ($research->researchAreas as $researchArea)
                                <li>
                                    {{ $researchArea->english }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($research->transversalResearchPrios->isNotEmpty())
                        <h4>
                            Transversal Research Priorities:
                        </h4>
                        <ul>
                            @foreach ($research->transversalResearchPrios as $prio)
                                <li>
                                    {{ $prio->english }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($research->keywords)
                        <h4>
                            Keywords:
                        </h4>
                        <ul>
                            @foreach ($research->keywords as $keyword)
                                <li>
                                    {{ $keyword }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
