<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            @if (request()->session()->get('mode', 'user') == 'admin')
                <a href="{{ route('admin.personal') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                    <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                    Return to List
                </a>
            @else
                <a href="{{ route('home') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                    <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                    Return to Dashboard
                </a>
            @endif
            <a href="{{ route('personal.edit', $user->uid) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Personal Data
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $user->first_name }} {{ $user->last_name }}
            </h2>
            <div class="TextImage--inner">
                @if ($user->orcid || $user->website || $user->phone || $user->cv_english || $user->cv_german || $user->research_focus_english || $user->research_focus_german || $user->researchAreas->isNotEmpty() || $user->employmentType->exists() || $user->transversalResearchPriorities->isNotEmpty())
                    <div class="TextImage--text richtext">
                        @if ($user->orcid)
                            <h4>
                                ORCID:
                            </h4>
                            {{ $user->orcid}}
                        @endif
                        @if ($user->website)
                            <h4>
                                Website:
                            </h4>
                            <a href="{{ $user->website }}" target="_blank">
                                {{ parse_url($user->website)['host'] }}
                            </a>
                        @endif
                        @if ($user->phone)
                            <h4>
                                Phone:
                            </h4>
                            <a href="tel:{{ $user->phone }}">
                                {{ $user->phone }}
                            </a>
                        @endif
                        @if ($user->cv_english)
                            <h4>
                                CV - English:
                            </h4>
                            {!! $user->cv_english !!}
                        @endif
                        @if ($user->cv_german)
                            <h4>
                                CV - German:
                            </h4>
                            {!! $user->cv_german !!}
                        @endif
                        @if ($user->research_focus_english)
                            <h4>
                                Research Focus - English:
                            </h4>
                            {!! $user->research_focus_english !!}
                        @endif
                        @if ($user->research_focus_german)
                            <h4>
                                Research Focus - German:
                            </h4>
                            {!! $user->research_focus_german !!}
                        @endif
                        @if($user->researchAreas->isNotEmpty())
                            <h4>
                                Research Areas:
                            </h4>
                            <ul>
                                @foreach ($user->researchAreas as $area)
                                    <li>
                                        {{ $area->english }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if($user->employmentType->exists())
                            <h4>
                                Employment Type:
                            </h4>
                            {{ $user->employmentType->english }}
                        @endif
                        @if($user->transversalResearchPriorities->isNotEmpty())
                            <h4>
                                Transversal Research Priorities:
                            </h4>
                            <ul>
                                @foreach ($user->transversalResearchPriorities as $prio)
                                    <li>
                                        {{ $prio->english }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @else
                    <div class="TextImage--text richtext">
                        <p>
                            Please edit your personal data to add more information.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-layout>
