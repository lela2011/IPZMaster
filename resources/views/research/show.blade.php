<x-layout>
    <div class="ContentArea">
        @if (request()->session()->get('mode', 'user') == 'admin')
            <x-back>
                <x-slot:route>
                    {{ route('admin.research') }}
                </x-slot:route>
                Return to list
            </x-back>
        @else
            <x-back>
                <x-slot:route>
                    {{ route('research.index') }}
                </x-slot:route>
                Return to list
            </x-back>
        @endif
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $researchProject->title }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    @if ($researchProject->title_original)
                        <h3>
                            {{ $researchProject->title_original }}
                        </h3>
                    @endif
                    <p>
                        {{ \Carbon\Carbon::parse($researchProject->start_date)->format('l, jS F Y') }} until {{ \Carbon\Carbon::parse($researchProject->end_date)->format('l, jS F Y') }}
                    </p>
                    @if($researchProject->summary)
                        <h4>
                            Summary:
                        </h4>
                        {!! $researchProject->summary !!}
                    @endif
                    @if($researchProject->summary_urls)
                        <h4>
                            Summary Links:
                        </h4>
                        @foreach ($researchProject->summary_urls as $url)
                            <a href="{{ $url }}" target="_blank">
                                {{ parse_url($url)['host'] }}
                            </a><br>
                        @endforeach
                    @endif
                    @if($researchProject->contributors)
                        <h4>
                            Contributors:
                        </h4>
                        <ul>
                            @foreach ($researchProject->contributors as $contributor)
                                <li>
                                    {{ $contributor }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($researchProject->fundings)
                        <h4>
                            Sources of Funding:
                        </h4>
                        <ul>
                            @foreach ($researchProject->fundings as $funding)
                                <li>
                                    {{ $funding }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($researchProject->institutions)
                        <h4>
                            Collaborating institutions:
                        </h4>
                        <ul>
                            @foreach ($researchProject->institutions as $institution)
                                <li>
                                    {{ $institution }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($researchProject->countrys)
                        <h4>
                            Collaborating Countries:
                        </h4>
                        <ul>
                            @foreach ($researchProject->countrys as $country)
                                <li>
                                    {{ $country }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($researchProject->zora_ids)
                        <h4>
                            ZORA:
                        </h4>
                        @foreach ($researchProject->zora_ids as $zora_id)
                            <a href="https://www.zora.uzh.ch/id/eprint/{{ $zora_id }}" target="_blank">
                                {{ $zora_id }}
                            </a><br>
                        @endforeach
                    @endif
                    @if ($researchProject->publication_url)
                        <h4>
                            Published in:
                        </h4>
                        <a href="{{ $researchProject->publication_url }}" target="_blank">
                            {{ parse_url($researchProject->publication_url)['host'] }}
                        </a>
                    @endif
                    @if ($researchProject->project_urls)
                        <h4>
                            External Resources:
                        </h4>
                        @foreach ($researchProject->project_urls as $url)
                            <a href="{{ $url }}" target="_blank">
                                {{ parse_url($url)['host'] }}
                            </a><br>
                        @endforeach
                    @endif
                    @if($researchProject->internalContacts->isNotEmpty() || $researchProject->externalContacts->isNotEmpty())
                        <h4>
                            Contacts:
                        </h4>
                        @if($researchProject->internalContacts->isNotEmpty())
                            <h5>
                                Internal:
                            </h5>
                            @foreach ($researchProject->internalContacts as $contact)
                                <a href="mailto:{{ $contact->email }}" target="_blank">
                                    {{ $contact->first_name }} {{ $contact->last_name }}
                                </a>
                                <br>
                            @endforeach
                        @endif
                        @if($researchProject->externalContacts->isNotEmpty())
                            <h5>
                                External:
                            </h5>
                            @foreach ($researchProject->externalContacts as $contact)
                                <a href="mailto:{{ $contact->email }}">
                                    {{ $contact->name }} ({{ $contact->organization }})
                                </a>
                                <br>
                            @endforeach
                        @endif
                    @endif
                    @if ($researchProject->researchAreas->isNotEmpty())
                        <h4>
                            Research Areas:
                        </h4>
                        <ul>
                            @foreach ($researchProject->researchAreas as $researchArea)
                                <li>
                                    {{ $researchArea->english }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($researchProject->transversalResearchPrios->isNotEmpty())
                        <h4>
                            Transversal Research Priorities:
                        </h4>
                        <ul>
                            @foreach ($researchProject->transversalResearchPrios as $prio)
                                <li>
                                    {{ $prio->english }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if ($researchProject->keywords)
                        <h4>
                            Keywords:
                        </h4>
                        <ul>
                            @foreach ($researchProject->keywords as $keyword)
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
