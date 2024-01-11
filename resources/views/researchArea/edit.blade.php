<x-layout>
    <div class="ContentArea">
        <x-back>
            <x-slot:route>
                {{ route('research-area.show', $researchArea->id) }}
            </x-slot:route>
            Return to Research Area Page
        </x-back>
        <x-flash-message/>
        <form class="Form js-Form" method="POST" id="Research Area Data Edit" action="{{route('research-area.update', $researchArea->id)}}">
            @method('PUT')
            @csrf
            <div class="Form--header">
                <h2 class="Form--title">
                    Please edit the research area data for {{ $researchArea->english }}
                </h2>
                <p class="Form--description">
                    - Changes will be visible on the research area page on ipz.uzh.ch<br>
                    - Fields may be left empty. Those fields won't be displayed on the personal page.
                </p>
            </div>
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="description_english">
                        Description - English
                    </label>
                    <textarea class="Input wysiwyg" name="description_english" id="description_english">
                        {{ old('description_english', $researchArea->description_english) }}
                    </textarea>
                    @error('description_english')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the english description of the research area.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="description_german">
                        Description - German
                    </label>
                    <textarea class="Input wysiwyg" name="description_german" id="description_german">
                        {{ old('description_german', $researchArea->description_german) }}
                    </textarea>
                    @error('description_german')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the german description of the research area.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="research_focus_english">
                        Research Focus - English
                    </label>
                    <textarea class="Input wysiwyg" name="research_focus_english" id="research_focus_english">
                        {{ old('research_focus_english', $researchArea->research_focus_english) }}
                    </textarea>
                    @error('research_focus_english')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the english research focus of the research area.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="research_focus_german">
                        Research Focus - German
                    </label>
                    <textarea class="Input wysiwyg" name="research_focus_german" id="research_focus_german">
                        {{ old('research_focus_german', $researchArea->research_focus_german) }}
                    </textarea>
                    @error('research_focus_german')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the english research focus of the research area.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="teaching_english">
                        Teaching and Supervision - English
                    </label>
                    <textarea class="Input wysiwyg" name="teaching_english" id="teaching_english">
                        {{ old('teaching_english', $researchArea->teaching_english) }}
                    </textarea>
                    @error('teaching_english')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the english teaching and supervisison information of the research area.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="teaching_german">
                        Teaching and Supervision - German
                    </label>
                    <textarea class="Input wysiwyg" name="teaching_german" id="teaching_german">
                        {{ old('teaching_german', $researchArea->teaching_german) }}
                    </textarea>
                    @error('teaching_german')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the german teaching and supervisison information of the research area.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="support_english">
                        Support Information - English
                    </label>
                    <textarea class="Input wysiwyg" name="support_english" id="support_english">
                        {{ old('support_english', $researchArea->support_english) }}
                    </textarea>
                    @error('support_english')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the english support information of the research area.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="support_german">
                        Support Information - German
                    </label>
                    <textarea class="Input wysiwyg" name="support_german" id="support_german">
                        {{ old('support_german', $researchArea->support_german) }}
                    </textarea>
                    @error('support_german')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Please enter the german support information of the research area.
                    </p>
                </div>
                <div class="FormButtons">
                    <a href="{{route('research-area.show', $researchArea->id)}}" class="Button color-border-white size-large">
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
