<x-iframe-layout>
    <h2 class="TextImage--title  richtext">Aktuelle Forschungsprojekte</h2>
    <form action="{{ url()->current() }}" method="get">
        <div class="FormInput">
            <label for="prio_filter" class="FormLabel">
                Transversaler Forschungsschwerpunkt:
            </label>
            <select name="prio_filter" id="prio_filter" class="Select" onchange="this.form.submit()">
                <option value="" selected=""></option>
                @foreach ($transvResearchPrios as $prio)
                    <option value="{{ $prio->id }}" @if (old('prio_filter', $prioFilter) == $prio->id) selected @endif>
                        {{ $prio->german }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="FormInput">
            <label for="area_filter" class="FormLabel">
                Forschungsbereich:
            </label>
            <select name="area_filter" id="area_filter" class="Select" onchange="this.form.submit()">
                <option value="" selected=""></option>
                @foreach ($researchAreas as $area)
                    <option value="{{ $area->id }}" @if (old('area_filter', $areaFilter) == $area->id) selected @endif>
                        {{ $area->german }}
                    </option>
                @endforeach
            </select>
        </div>
        <noscript><input type="submit" value="Submit"></noscript>
    </form>
    @if ($projects->isNotEmpty())
        <div class="NewsList">
            <ul class="NewsList--list">
                @foreach ($projects as $project)
                    <li>
                        <div class="NewsListItem research">
                            <div class="NewsListItem--content">
                                <div class="NewsListItem--date">
                                    {{ \Carbon\Carbon::parse($project->start_date)->locale('de')->isoFormat('dddd, D. MMMM YYYY') }} —
                                    {{ \Carbon\Carbon::parse($project->end_date)->locale('de')->isoFormat('dddd, D. MMMM YYYY') }}
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
                                            Zusammenfassung:
                                        </h4>
                                        {!! $project->summary !!}
                                    @endif
                                    @if ($project->summary_urls)
                                        <h4>
                                            Zussammenfassende Links:
                                        </h4>
                                        @foreach ($project->summary_urls as $url)
                                            <a href="{{ $url }}" target="_blank">
                                                {{ parse_url($url)['host'] }}
                                            </a><br>
                                        @endforeach
                                    @endif
                                    @if ($project->contributors)
                                        <h4>
                                            Mitwirkende:
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
                                            Finanzierung:
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
                                            Mitwirkende Institutionen:
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
                                            Mitwirkende Staaten:
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
                                            Veröffentlicht in:
                                        </h4>
                                        <a href="{{ $project->publication_url }}" target="_blank">
                                            {{ parse_url($project->publication_url)['host'] }}
                                        </a>
                                    @endif
                                    @if ($project->project_urls)
                                        <h4>
                                            Externe Ressourcen:
                                        </h4>
                                        @foreach ($project->project_urls as $url)
                                            <a href="{{ $url }}" target="_blank">
                                                {{ parse_url($url)['host'] }}
                                            </a><br>
                                        @endforeach
                                    @endif
                                    @if ($project->internalContacts->isNotEmpty() || $project->externalContacts->isNotEmpty())
                                        <h4>
                                            Kontakte:
                                        </h4>
                                        @if ($project->internalContacts->isNotEmpty())
                                            <h5>
                                                Intern:
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
                                                Extern:
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
                                            Forschungsbereiche:
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
                                            Transversale Forschungsschwerpunkte:
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
                                            Schlagwörter:
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
                                        Mehr anzeigen
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        {{ $projects->withQueryString()->links('pagination.uzh-pagination-de') }}
    @else
        <div class="TextImage--content richtext" style="margin-top: 24px">
            <p>
                Es wurden keine Forschungsprojekte gefunden.
            </p>
        </div>
    @endif
</x-iframe-layout>
<script>
    $(document).ready(function() {
        $('.toggle-research-detail').click(function() {
            var index = $('.toggle-research-detail').index(this);
            var anchor = $(this).find('a')
            var researchDetail = $('.research-detail').eq(index);

            researchDetail.toggleClass('visible hidden');
            researchDetail.scrollTop(0);

            if (researchDetail.hasClass('visible')) {
                anchor.text('Weniger anzeigen');
            } else {
                anchor.text('Mehr anzeigen');
            }
        });
    });
</script>
