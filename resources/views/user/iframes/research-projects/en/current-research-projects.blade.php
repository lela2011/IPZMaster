@if ($projects->isNotEmpty())
    <x-iframe-layout>
        <h2 class="TextImage--title  richtext">Current Research Projects</h2>
        <div class="NewsList">
            <ul class="NewsList--list">
                @foreach ($projects as $project)
                    <li>
                        <div class="NewsListItem research">
                            <div class="NewsListItem--content">
                                <div class="NewsListItem--date">
                                    {{ \Carbon\Carbon::parse($project->start_date)->format('l, jS F Y') }} —
                                    {{ \Carbon\Carbon::parse($project->end_date)->format('l, jS F Y') }}
                                </div>
                                <h3 class="NewsListItem--title">
                                    {{ $project->title }}
                                </h3>
                                <div class="TextImage--text richtext research-detail hidden">
                                    @if ($project->title_original)
                                        <h4 style="margin-top: 8px">
                                            {{ $project->title_original }}
                                        </h4>
                                    @endif
                                    @if ($project->summary)
                                        <h4>
                                            Summary:
                                        </h4>
                                        {!! $project->summary !!}
                                    @endif
                                    @if ($project->summary_urls)
                                        <h4>
                                            Summary Links:
                                        </h4>
                                        @foreach ($project->summary_urls as $url)
                                            <a href="{{ $url }}" target="_blank">
                                                {{ parse_url($url)['host'] }}
                                            </a><br>
                                        @endforeach
                                    @endif
                                    @if ($project->contributors)
                                        <h4>
                                            Contributors:
                                        </h4>
                                        <ul>
                                            @foreach ($project->contributors as $contributor)
                                                <li>
                                                    {{ $contributor }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($project->fundings)
                                        <h4>
                                            Sources of Funding:
                                        </h4>
                                        <ul>
                                            @foreach ($project->fundings as $funding)
                                                <li>
                                                    {{ $funding }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($project->institutions)
                                        <h4>
                                            Collaborating Institutions:
                                        </h4>
                                        <ul>
                                            @foreach ($project->institutions as $institution)
                                                <li>
                                                    {{ $institution }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($project->countrys)
                                        <h4>
                                            Collaborating Countries:
                                        </h4>
                                        <ul>
                                            @foreach ($project->countrys as $country)
                                                <li>
                                                    {{ $country }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($project->zora_ids)
                                        <h4>
                                            ZORA:
                                        </h4>
                                        @foreach ($project->zora_ids as $zora_id)
                                            <a href="https://www.zora.uzh.ch/id/eprint/{{ $zora_id }}"
                                                target="_blank">
                                                {{ $zora_id }}
                                            </a><br>
                                        @endforeach
                                    @endif
                                    @if ($project->publication_url)
                                        <h4>
                                            Published in:
                                        </h4>
                                        <a href="{{ $project->publication_url }}" target="_blank">
                                            {{ parse_url($project->publication_url)['host'] }}
                                        </a>
                                    @endif
                                    @if ($project->project_urls)
                                        <h4>
                                            External Resources:
                                        </h4>
                                        @foreach ($project->project_urls as $url)
                                            <a href="{{ $url }}" target="_blank">
                                                {{ parse_url($url)['host'] }}
                                            </a><br>
                                        @endforeach
                                    @endif
                                    @if ($project->internalContacts->isNotEmpty() || $project->externalContacts->isNotEmpty())
                                        <h4>
                                            Contacts:
                                        </h4>
                                        @if ($project->internalContacts->isNotEmpty())
                                            <h5>
                                                Internal:
                                            </h5>
                                            @foreach ($project->internalContacts as $contact)
                                                <a href="mailto:{{ $contact->email }}" target="_blank">
                                                    {{ $contact->first_name }} {{ $contact->last_name }}
                                                </a>
                                                <br>
                                            @endforeach
                                        @endif
                                        @if ($project->externalContacts->isNotEmpty())
                                            <h5>
                                                External:
                                            </h5>
                                            @foreach ($project->externalContacts as $contact)
                                                <a href="mailto:{{ $contact->email }}">
                                                    {{ $contact->name }} ({{ $contact->organization }})
                                                </a>
                                                <br>
                                            @endforeach
                                        @endif
                                    @endif
                                    @if ($project->researchAreas->isNotEmpty())
                                        <h4>
                                            Research Areas:
                                        </h4>
                                        <ul>
                                            @foreach ($project->researchAreas as $researchArea)
                                                <li>
                                                    {{ $researchArea->german }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($project->transversalResearchPrios->isNotEmpty())
                                        <h4>
                                            Transversal Research Priorities:
                                        </h4>
                                        <ul>
                                            @foreach ($project->transversalResearchPrios as $prio)
                                                <li>
                                                    {{ $prio->german }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($project->keywords)
                                        <h4>
                                            Keywords:
                                        </h4>
                                        <ul>
                                            @foreach ($project->keywords as $keyword)
                                                <li>
                                                    {{ $keyword }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="NewsListItem--link toggle-research-detail">
                                    <a class="Link">
                                        Show more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        {{ $projects->links('pagination.uzh-pagination-en') }}
    </x-iframe-layout>
@endif
<script>
    $(document).ready(function() {
        $('.toggle-research-detail').click(function() {
            var index = $('.toggle-research-detail').index(this);
            var anchor = $(this).find('a')
            var researchDetail = $('.research-detail').eq(index);

            researchDetail.toggleClass('visible hidden');
            researchDetail.scrollTop(0);

            if (researchDetail.hasClass('visible')) {
                anchor.text('Show less');
            } else {
                anchor.text('Show more');
            }
        });
    });
</script>
