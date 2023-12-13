<x-layout>
    <div class="ContentArea">
        <x-back>
            <x-slot:route>
                {{ route('home') }}
            </x-slot:route>
            Return to dashboard
        </x-back>
        <x-flash-message/>
        <form class="Form js-Form" method="POST" id="Personal Data Edit" action="{{route('personal.update')}}">
            @csrf
            <div class="Form--header">
                <h2 class="Form--title">
                    Please edit the personal data for {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                </h2>
                <p class="Form--description">
                    - Changes will be visible on the personal page on ipz.uzh.ch<br>
                    - Fields may be left empty. Those fields won't be displayed on the personal page.
                </p>
            </div>
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="orcid_1">
                        ORCID
                    </label>
                    <div style="display: flex; align-items: center;">
                        <input type="text" class="Input orcid-input" maxlength="4" name="orcid[]" id="orcid_1"
                               value="{{ old('orcid', $orcid)[0] ?? "" }}">
                        <span class="separator">-</span>
                        <input type="text" class="Input orcid-input" maxlength="4" name="orcid[]" id="orcid_2"
                               value="{{ old('orcid', $orcid)[1] ?? "" }}">
                        <span class="separator">-</span>
                        <input type="text" class="Input orcid-input" maxlength="4" name="orcid[]" id="orcid_3"
                               value="{{ old('orcid', $orcid)[2] ?? "" }}">
                        <span class="separator">-</span>
                        <input type="text" class="Input orcid-input" maxlength="4" name="orcid[]" id="orcid_4"
                               value="{{ old('orcid', $orcid)[3] ?? "" }}">
                    </div>
                    @error('orcid')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Type or paste ORCID. When pasting hyphens may be pasted.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="website">
                        Website
                    </label>
                    <input class="Input" name="website" id="website"
                           value="{{ old('website', Auth::user()->website) }}">
                    @error('website')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the linkt to your personal website in the form http(s)://www.website.com.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="cv_english">
                        CV - English
                    </label>
                    <textarea class="Input wysiwyg" name="cv_english"
                              id="cv_english">{{ old('cv_english', Auth::user()->cv_english) }}</textarea>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="cv_german">
                        CV - German
                    </label>
                    <textarea class="Input wysiwyg" name="cv_german"
                              id="cv_english">{{ old('cv_german', Auth::user()->cv_german) }}</textarea>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="research_focus_english">
                        Research Focus - English
                    </label>
                    <textarea class="Input wysiwyg" name="research_focus_english"
                              id="research_focus_english">{{ old('research_focus_english', Auth::user()->research_focus_english) }}</textarea>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="research_focus_german">
                        Research Focus - German
                    </label>
                    <textarea class="Input wysiwyg" name="research_focus_german"
                              id="research_focus_german">{{ old('research_focus_german', Auth::user()->research_focus_german) }}</textarea>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="research_areas">
                        Research Areas
                    </label>
                    <select id="research_areas" name="research_areas[]" multiple>
                        @foreach($researchAreaOptions as $researchAreaOption)
                            <option value="{{ $researchAreaOption->id }}"
                                    @if(collect(old('research_areas', $researchAreas))->contains($researchAreaOption->id))
                                        selected
                                @endif
                            >{{ $researchAreaOption->english }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="transv_research_prios">
                        Transversal Research Priorities
                    </label>
                    <select id="transv_research_prios" name="transv_research_prios[]" multiple>
                        @foreach($transvResearchPrioOptions as $prio)
                            <option value="{{ $prio->id }}"
                                @if(collect(old('transv_research_prios', $transvResearchPrios))->contains($prio->id))
                                    selected
                                @endif
                            >{{ $prio->english }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="FormButtons">
                    <a href="{{route('home')}}" class="Button color-border-white size-large">
                        <span class="Button--inner">
                            Cancel
                        </span>
                    </a>
                    <button class="Button color-primary size-large" type="submit">
                        <span class="Button--inner">
                            Update
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>

<script>
    // Executes when the document is fully loaded
    $(document).ready(function () {

        // For each element with class 'orcid-input'
        $('.orcid-input').each(function (index) {

            // Listens to input events on each 'orcid-input'
            $(this).on('input', function () {
                // Converts input to uppercase
                let input = $(this).val().toUpperCase();

                // Validates input length and characters
                if (input.length === this.maxLength && index === $('.orcid-input').length - 1) {
                    let finalChar = input.charAt(this.maxLength - 1);

                    // Removes non-numeric characters if final character is invalid
                    if (!(/^[0-9X]$/i.test(finalChar))) {
                        input = input.slice(0, -1);
                    }
                } else {
                    // Removes non-numeric characters
                    input = input.replace(/\D/g, '');
                }

                // Sets the cleaned input value
                $(this).val(input)

                // Moves focus to the next input if length limit reached
                if (input.length === parseInt(this.maxLength)) {
                    if (index < $('.orcid-input').length - 1) {
                        $('.orcid-input').eq(index + 1).focus();
                    }
                }
            });

            // Listens to keydown events (Backspace) for navigation
            $(this).on('keydown', function (event) {
                if (event.key === 'Backspace' && this.selectionStart === 0 && index > 0) {
                    // Moves cursor to the previous input on backspace
                    const inputField = $('.orcid-input').eq(index - 1);
                    const end = inputField.val().length;
                    inputField[0].setSelectionRange(end, end);
                    inputField.focus();
                }
            });

            // Listens to paste events for ORCID format
            $(this).on('paste', function (event) {
                event.preventDefault();
                let pastedText = (event.originalEvent.clipboardData || window.clipboardData).getData('text');
                pastedText = pastedText.replace(/-/g, '');

                // Validates pasted text against ORCID format
                let regexTest15 = /^\d{1,15}$/
                let regexTest16 = /^\d{15}(\d|X)$/
                if (regexTest15.test(pastedText) || regexTest16.test(pastedText)) {
                    const segments = pastedText.match(/.{1,4}/g);

                    // Distributes pasted segments among input fields
                    const available = $('.orcid-input').length - index;
                    if (available >= segments.length) {
                        let localIndex = index;
                        let segmentIndex = 0;
                        while (localIndex < 4) {
                            if (segments[segmentIndex] === undefined)
                                break;

                            $('.orcid-input').eq(localIndex).val(segments[segmentIndex]);
                            localIndex++;
                            segmentIndex++;
                        }
                    } else {
                        let segmentIndex = 0;
                        while (segmentIndex < segments.length) {
                            if (segments[segmentIndex] === undefined)
                                break;

                            $('.orcid-input').eq(segmentIndex).val(segments[segmentIndex]);
                            segmentIndex++;
                        }
                    }
                }
            });
        });

        // Initializes 'research_areas' selectize
        $('#research_areas').selectize({
            closeAfterSelect: true,
            sortField: 'text',
        });

        // Initializes 'transv_research_prios' selectize
        $('#transv_research_prios').selectize({
            closeAfterSelect: true,
            sortField: 'text'
        });
    });
</script>
