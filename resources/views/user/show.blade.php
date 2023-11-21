<x-layout>
    <div class="ContentArea">
        <form class="Form js-Form" method="POST" id="Personal Data Edit" action="/personal/update">
            @csrf
            <div class="Form--header">
                <h2 class="Form-title">
                    Please edit the personal data for {{Auth::user()->employeeProfile->first_name}} {{Auth::user()->employeeProfile->last_name}}
                </h2>
            </div>
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="orcid">
                        ORCID
                    </label>
                    <input class="Input" name="orcid" id="orcid" maxlength="19" oninput="formatORCID(this)" value="{{ Auth::user()->employeeProfile->orcid }}">
                    <p class="FormDescription">
                        hyphens will be added automatically.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="cv">
                        CV
                    </label>
                    <textarea class="Input" name="cv" id="cv">{{ Auth::user()->employeeProfile->cv }}</textarea>
                </div>
                <div class="FormInput" id="research-area-fields">
                    <label class="FormLabel">
                        Research areas
                    </label>
                    <div id="movable-area-fields">
                        @foreach($research_areas as $area)
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
                            <option value="{{ $prio->transv_id }}">
                                {{ $prio->english }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="FormButtons">
                    <a href="/" class="Button color-border-white size-large">
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
    const orcidInput = document.getElementById('orcid');

    orcidInput.addEventListener('input', function(event) {
        let uncheckedInput = event.target.value.toUpperCase()
        let input = uncheckedInput.replace(/\D/g, '').substring(0,15);
        input = input.replace(/(\d{4})(?!$)/g, '$1-');

        if(uncheckedInput.length === 19) {
            let finalChar = uncheckedInput.slice(-1);
            if(/^[0-9X]$/i.test(finalChar)) {
                input += finalChar;
            }
        }

        event.target.value = input;
    });

    document.addEventListener('input', function(event) {
        const inputs = document.querySelectorAll('.research-area');
        const movableFields = document.getElementById('movable-area-fields');
        const lastInput = inputs[inputs.length - 1];

        if (event.target === lastInput && lastInput.value.trim() !== '') {
            movableFields.appendChild(lastInput)
            lastInput.focus()
            const newField = `<input name="research_areas[]" class="Input research-area" id="area_${inputs.length + 1}" style='margin-bottom: 8px;'>`;
            document.getElementById('description').insertAdjacentHTML('beforebegin', newField);
        }
    });

    document.addEventListener('blur', function(event) {
        const currentInput = event.target;

        if (currentInput.classList.contains('research-area')) {
            const inputs = document.querySelectorAll('.research-area');

            if (currentInput.value.trim() === '' && inputs.length > 1 && currentInput !== inputs[inputs.length - 1]) {
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

