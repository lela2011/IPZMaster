<x-layout>
    <div class="ContentArea">
        <x-back/>
        <x-flash-message />
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
                        <input type="text" class="Input orcid-input" maxlength="4" name="orcid[]" id="orcid_1" value="{{ old('orcid', $orcid)[0] ?? "" }}">
                        <span class="separator">-</span>
                        <input type="text" class="Input orcid-input" maxlength="4" name="orcid[]" id="orcid_2" value="{{ old('orcid', $orcid)[1] ?? "" }}">
                        <span class="separator">-</span>
                        <input type="text" class="Input orcid-input" maxlength="4" name="orcid[]" id="orcid_3" value="{{ old('orcid', $orcid)[2] ?? "" }}">
                        <span class="separator">-</span>
                        <input type="text" class="Input orcid-input" maxlength="4" name="orcid[]" id="orcid_4" value="{{ old('orcid', $orcid)[3] ?? "" }}">
                    </div>
                    @error('orcid')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <p class="FormDescription">
                    Type or paste ORCID. When pasting hyphens may be pasted.
                </p>
                <div class="FormInput">
                    <label class="FormLabel" for="cv">
                        CV
                    </label>
                    <textarea class="Input" name="cv" id="cv">{{ old('cv', Auth::user()->cv) }}</textarea>
                </div>
                <div class="FormInput" id="research-area-fields">
                    <label class="FormLabel">
                        Research areas
                    </label>
                    <div id="movable-area-fields">
                        @foreach(array_filter(old('research_areas', $research_areas), fn ($value) => !is_null($value)) as $area)
                            <input class="Input research-area"
                                   name="research_areas[]"
                                   value="{{$area}}"
                                   id="area_{{$loop->iteration}}"
                                   style="margin-bottom: 8px">
                        @endforeach
                    </div>
                    <input class="Input research-area"
                           name="research_areas[]"
                           value=""
                           id="area_{{count($research_areas) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="description">
                        Type into the empty field to add a new research area. / Remove a research area by deleting the text of a field and clicking out of it. / Reorder the fields by drag and drop.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="transv_research_prio">Transversal Research Priorities</label>
                    <select class="Select" id="transv_research_prio" name="transv_research_prio">
                        @foreach($transv_research_prios as $prio)
                            <option value="{{ $prio->transv_id }}"
                                    @if(old('transv_research_prio', Auth::user()->transv_research_prio) === $prio->transv_id)
                                        selected="selected"
                                    @endif
                            >
                                {{ $prio->english }}
                            </option>
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

    const inputFields = document.querySelectorAll('.orcid-input');

    inputFields.forEach((field, index) => {
        // listens for the user to type
        field.addEventListener('input', (event) => {
            let input = event.target.value.toUpperCase(); // capitalizes characters

            // checks if input was the last character in the last input block
            if (input.length === field.maxLength && index === inputFields.length - 1) {
                // extracts last character
                let finalChar = input.charAt(field.maxLength - 1)
                //checks if last character is 0-9 or X
                if (!(/^[0-9X]$/i.test(finalChar))) {
                    // if not then it will be removed
                    input = input.slice(0, -1);
                }
            } else {
                // checks if typed character is a digit and removes it if not
                input = input.replace(/\D/g, '')
            }
            // update typed input
            event.target.value = input;

            //checks if maximum allowed characters were typed
            if (input.length === parseInt(event.target.getAttribute('maxlength'))) {
                // checks if cursor is not in final input block
                if (index < inputFields.length - 1) {
                    // moves focus to next input field
                    inputFields[index + 1].focus();
                }
            }
        });

        // listens for the user to press a key
        field.addEventListener('keydown', (event) => {
            // checks if key is backspace and if cursor is at beginning of input field and if cursor is not in first field
            if (event.key === 'Backspace' && event.target.selectionStart === 0 && index > 0) {
                // stores the input field the cursor should jump to in a variable
                const inputField = inputFields[index-1]
                // stores the current amount of characters in the future field
                const end = inputField.value.length;
                // sets cursor to the end of the future field
                inputField.setSelectionRange(end, end);
                // moves focus to the future field
                inputField.focus();
            }
        });

        //handles pasting into any field
        field.addEventListener('paste', (event) => {
            // stops default past logic from being preformed
            event.preventDefault();
            // retrieves text from clipboard
            let pastedText = (event.clipboardData || window.clipboardData).getData('text');
            // removes hyphens from provided orcid
            pastedText = pastedText.replace(/-/g, '');
            // splits cleaned orcid every 4 characters
            const segments = pastedText.match(/.{1,4}/g);

            // checks how many fields are available to be pasted into from the current location
            const available = inputFields.length - index;
            // checks if the amount of segments fits into available fields
            if(available >= segments.length) {
                let localIndex = index;
                let segmentIndex = 0;
                while(localIndex < 4) {
                    // stops pasting when all segments pasted
                    if(segments[segmentIndex] === undefined)
                        break;

                    // pastes segments into fields
                    inputFields[localIndex].value = segments[segmentIndex];
                    localIndex++;
                    segmentIndex++;
                }
            } else { // when space not sufficient, clipboard is pasted at first field
                let segmentIndex = 0;
                while(segmentIndex < segments.length) {
                    // stops pasting when all segments pasted
                    if(segments[segmentIndex] === undefined)
                        break;

                    // pastes segments into fields
                    inputFields[segmentIndex].value = segments[segmentIndex];
                    segmentIndex++;
                }
            }
        });
    });

</script>

<script>
    // listens to inputs being made on the website
    document.addEventListener('input', function(event) {
        // retrieves all research-area input fields
        const inputs = document.querySelectorAll('.research-area');
        // retrieves div with movable fields
        const movableFields = document.getElementById('movable-area-fields');
        // retrieves current empty last input
        const lastInput = inputs[inputs.length - 1];

        // checks if user types into currently last input
        if (event.target === lastInput && lastInput.value.trim() !== '') {
            // moves former old input into div of movable inputs
            movableFields.appendChild(lastInput)
            // focuses on input to allow user to type
            lastInput.focus()
            // creates new empty input
            const newField = `<input name="research_areas[]" class="Input research-area" id="area_${inputs.length + 1}" style='margin-bottom: 8px;'>`;
            // appends it to list but not movable list
            document.getElementById('description').insertAdjacentHTML('beforebegin', newField);
        }
    });

    // listens for lost of focus
    document.addEventListener('blur', function(event) {
        // stores input that lost focus in variable
        const currentInput = event.target;

        // checks if input is for research-area
        if (currentInput.classList.contains('research-area')) {
            // retrieves all research-area inputs
            const inputs = document.querySelectorAll('.research-area');

            // checks if current input is empty and whether unfocused input is the last one in the list
            if (currentInput.value.trim() === '' && inputs.length > 1 && currentInput !== inputs[inputs.length - 1]) {
                // animates removal of input
                currentInput.style.transition = 'opacity 0.5s ease-out';
                currentInput.style.opacity = '0';

                setTimeout(() => {
                    currentInput.remove();
                }, 500);
            }
        }
    }, true);

    // Initialize Sortable.js for reordering
    const sortable = Sortable.create(document.getElementById('movable-area-fields'), {
        animation: 150,
        draggable: '.research-area',
    });
</script>

