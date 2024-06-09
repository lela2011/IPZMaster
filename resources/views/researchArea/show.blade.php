<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            @if (request()->session()->get('mode', 'user') == 'admin')
                <a href="{{ route('admin.research-area') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                    <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                    Return to List
                </a>
            @else
                <a href="{{ route('home') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                    <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                    Return to Dashboard
                </a>
            @endif
            <a href="{{ route('research-area.edit', $researchArea->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Research Area Data
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
            <div class="TextImage">
                <h2 class="TextImage--title richtext">
                    {{ $researchArea->english }}
                </h2>
                @if($researchArea->description_english || $researchArea->description_german || $researchArea->research_focus_english || $researchArea->research_focus_german || $researchArea->teaching_english || $researchArea->teaching_german || $researchArea->support_english || $researchArea->support_german)
                    <div class="TextImage--inner">
                        <div class="TextImage--text richtext">
                            @if ($researchArea->description_english)
                                <h4>
                                    Description - English:
                                </h4>
                                {!! $researchArea->description_english !!}
                            @endif
                        </div>
                        <div class="TextImage--text richtext">
                            @if ($researchArea->description_german)
                                <h4>
                                    Description - German:
                                </h4>
                                {!! $researchArea->description_german !!}
                            @endif
                        </div>
                        <div class="TextImage--text richtext">
                            @if ($researchArea->research_focus_english)
                                <h4>
                                    Research Focus - English:
                                </h4>
                                {!! $researchArea->research_focus_english !!}
                            @endif
                        </div>
                        <div class="TextImage--text richtext">
                            @if ($researchArea->research_focus_german)
                                <h4>
                                    Research Focus - German:
                                </h4>
                                {!! $researchArea->research_focus_german !!}
                            @endif
                        </div>
                        <div class="TextImage--text richtext">
                            @if ($researchArea->teaching_english)
                                <h4>
                                    Teaching and supervision - English:
                                </h4>
                                {!! $researchArea->teaching_english !!}
                            @endif
                        </div>
                        <div class="TextImage--text richtext">
                            @if ($researchArea->teaching_german)
                                <h4>
                                    Teaching and supervision - German:
                                </h4>
                                {!! $researchArea->teaching_german !!}
                            @endif
                        </div>
                        <div class="TextImage--text richtext">
                            @if ($researchArea->teaching_german)
                                <h4>
                                    Support Information - English:
                                </h4>
                                {!! $researchArea->support_english !!}
                            @endif
                        </div>
                        <div class="TextImage--text richtext">
                            @if ($researchArea->teaching_german)
                                <h4>
                                    Support Information - German:
                                </h4>
                                {!! $researchArea->support_german !!}
                            @endif
                        </div>
                    </div>
                @else
                    <div class="TextImage--text richtext">
                        <p>
                            Please edit the data of the research area to add more information.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
