<x-layout>
    <div class="ContentArea">
        <x-back>
            <x-slot:route>
                {{ route('personal.show', $user->uid) }}
            </x-slot:route>
            Return to Personal Page
        </x-back>
        <x-flash-message/>
        <form class="Form js-Form" method="POST" id="Personal Data Edit" action="{{route('personal.update', $user->uid)}}">
            @method('PUT')
            @csrf
            <div class="Form--header">
                <h2 class="Form--title">
                    Please edit the personal data for {{$user->first_name}} {{$user->last_name}}
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
                        Type or paste an ORCID. When pasting hyphens may be pasted.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="website">
                        Website
                    </label>
                    <input class="Input" name="website" id="website"
                           value="{{ old('website', $user->website) }}">
                    @error('website')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the link to your personal website.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="phone">
                        Phone
                    </label>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 8px">+41</span>
                        <input class="Input" name="phone" id="phone"
                           value="{{ old('phone', substr($user->phone, 4)) }}">
                    </div>
                    @error('phone')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter your office phone number.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="cv_english">
                        CV - English
                    </label>
                    <textarea class="Input wysiwyg" name="cv_english"
                              id="cv_english">{{ old('cv_english', $user->cv_english) }}</textarea>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="cv_german">
                        CV - German
                    </label>
                    <textarea class="Input wysiwyg" name="cv_german"
                              id="cv_english">{{ old('cv_german', $user->cv_german) }}</textarea>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="research_focus_english">
                        Research Focus - English
                    </label>
                    <textarea class="Input wysiwyg" name="research_focus_english"
                              id="research_focus_english">{{ old('research_focus_english', $user->research_focus_english) }}</textarea>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="research_focus_german">
                        Research Focus - German
                    </label>
                    <textarea class="Input wysiwyg" name="research_focus_german"
                              id="research_focus_german">{{ old('research_focus_german', $user->research_focus_german) }}</textarea>
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
                    <p class="FormDescription">
                        Select one or multiple research areas.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="employment_type">
                        Employment Type
                    </label>
                    <select class="Select" id="employment_type" name="employment_type">
                        <option value=""></option>
                        @foreach($employmentTypes as $employmentType)
                            <option value="{{ $employmentType->id }}"
                                @if(old('employment_type', $user->employmentType->id ?? '') == $employmentType->id)
                                        selected
                                @endif
                            >{{ $employmentType->singular }}</option>
                        @endforeach
                    </select>
                    @error('employment_type')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Select your employment type for the research areas you work for.
                    </p>
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
                    <p class="FormDescription">
                        Select one or multiple transversal research priorities.
                    </p>
                </div>
                <div class="FormButtons">
                    <a href="{{route('personal.show', $user->uid)}}" class="Button color-border-white size-large">
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

        // styles phone input
        $('#phone').on('input', function () {
            // Removes non-numeric characters
            let input = $(this).val().replace(/\D/g, '');
            let diff = 1;

            if (event.inputType === 'deleteContentBackward') {
                diff = 0;
            }

            // Save current cursor position
            let cursorPosition = this.selectionStart;

            // Adds spaces after 2, 6 and 9 digits
            if (input.length > 2) {
                input = input.substring(0, 2) + ' ' + input.substring(2);
            }
            if (input.length > 6) {
                input = input.substring(0, 6) + ' ' + input.substring(6);
            }
            if (input.length > 9) {
                input = input.substring(0, 9) + ' ' + input.substring(9);
            }

            // Limits input length to 12 characters
            if (input.length > 12) {
                input = input.substring(0, 12);
            }

            // Sets the cleaned input value
            $(this).val(input);

            // Moves cursor to the right position
            this.setSelectionRange(cursorPosition + diff, cursorPosition + diff);
        });

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
