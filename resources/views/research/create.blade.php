@php use Webpatser\Countries\Countries; @endphp
<x-layout>
    <x-contact-modal/>
    <x-confirm-modal/>
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
        <x-flash-message/>
        <form class="Form js-Form" method="POST" id="Create Research Project" action="{{ route('research.store') }}">
            @csrf
            <div class="Form--header">
                <h2 class="Form--title">
                    Fill in the details to create a new research project
                </h2>
            </div>
            <div class="Form--body">
                <!-- English Title -->
                <div class="FormInput">
                    <label class="FormLabel" for="title">
                        English title
                    </label>
                    <input class="Input" id="title" name="title" value="{{ old('title') }}">
                    @error('title')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <!-- Original Title -->
                <div class="FormInput">
                    <label class="FormLabel" for="title_original">
                        Original title
                    </label>
                    <input class="Input" id="title_original" name="title_original" value="{{ old('title_original') }}">
                    @error('title_original')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Only fill this field with the original projects title if it differs from the english title field.
                    </p>
                </div>
                <!-- Publish -->
                <div class="FormInput">
                    <label class="FormLabel" for="contactOption">
                        Display research project publicly
                    </label>
                    <div class="Options js-OptionInput" id="contactOption">
                        <div class="OptionInput">
                            <input type="checkbox" id="publish" value="1" name="publish" @if(old('publish')) checked @endif>
                            <label for="publish">
                                Publish
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Date Range -->
                <div class="FormInput">
                    <label class="FormLabel" for="date_range">
                        Time Frame
                    </label>
                    <input class="Input" type="text" id="date_range" name="date_range" value="{{ old('date_range') }}">
                    @error('start_date')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    @error('end_date.date')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <!-- Summary -->
                <div class="FormInput">
                    <label class="FormLabel" for="summary">
                        Summary
                    </label>
                    <textarea class="Input wysiwyg" id="summary" name="summary">{{ old('summary') }}</textarea>
                    @error('summary')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <!-- Summary URLs -->
                <div class="FormInput">
                    <label class="FormLabel" for="summary_url">
                        Summary links
                    </label>
                    @foreach(filterEmptyArray(old('summary_urls')) as $link)
                        <input class="Input summary_url"
                               name="summary_urls[]"
                               id="summary_url_{{$loop->iteration}}"
                               value="{{ $link }}"
                               style="margin-bottom: 8px">
                        @error('summary_urls.' . $loop->index)
                        <p class="has-error" style="color: red; margin-bottom: 8px" id="summary_url_{{$loop->iteration}}_error">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    @endforeach
                    <input class="Input summary_url"
                           name="summary_urls[]"
                           id="summary_url_{{count(filterEmptyArray(old('summary_url'))) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="summary_urls_description">
                        Type into the empty field to add a new summary link. / Remove a summary link by deleting the
                        text of a field and clicking out of it.
                    </p>
                    @error('summary_urls')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <!-- Zora IDs -->
                <div class="FormInput">
                    <label class="FormLabel" for="zora_ids">
                        Zora IDs
                    </label>
                    @foreach(filterEmptyArray(old('zora_ids')) as $id)
                        <input class="Input zora_id"
                               name="zora_ids[]"
                               id="zora_id_{{$loop->iteration}}"
                               value="{{ $id }}"
                               style="margin-bottom: 8px">
                        @error('zora_ids.' . $loop->index)
                        <p class="has-error" style="color: red; margin-bottom: 8px" id="zora_id_{{$loop->iteration}}_error">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    @endforeach
                    <input class="Input zora_id"
                           name="zora_ids[]"
                           id="zora_id_{{count(filterEmptyArray(old('zora_ids'))) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="zora_ids_description">
                        Type into the empty field to add a new Zora id. / Remove a Zora id by deleting the text of a
                        field and clicking out of it.
                    </p>
                    @error('zora_ids')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <!-- publication url -->
                <div class="FormInput">
                    <label class="FormLabel" for="publication_url">
                        Publication link
                    </label>
                    <input class="Input" id="publication_url" name="publication_url"
                           value="{{ old('publication_url') }}">
                    @error('publication_url')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <!-- Project urls -->
                <div class="FormInput">
                    <label class="FormLabel" for="project_urls">
                        Project links
                    </label>
                    @foreach(filterEmptyArray(old('project_urls')) as $url)
                        <input class="Input project_url"
                               name="project_urls[]"
                               id="project_url_{{$loop->iteration}}"
                               value="{{ $url }}"
                               style="margin-bottom: 8px">
                        @error('project_urls.' . $loop->index)
                        <p class="has-error" style="color: red; margin-bottom: 8px" id="project_url_{{$loop->iteration}}_error">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    @endforeach
                    <input class="Input project_url"
                           name="project_urls[]"
                           id="project_url_{{count(filterEmptyArray(old('project_urls'))) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="project_urls_description">
                        Type into the empty field to add a new project url. / Remove a project url by deleting the text
                        of a field and clicking out of it.
                    </p>
                    @error('project_urls')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <!-- Funding -->
                <div class="FormInput">
                    <label class="FormLabel" for="funding">
                        Funding
                    </label>
                    @foreach(filterEmptyArray(old('fundings')) as $funding)
                        <input class="Input funding"
                               name="fundings[]"
                               id="funding_{{$loop->iteration}}"
                               value="{{ $funding }}"
                               style="margin-bottom: 8px">
                        @error('fundings.' . $loop->index)
                        <p class="has-error" style="color: red" id="funding_{{$loop->iteration}}_error">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    @endforeach
                    <input class="Input funding"
                           name="fundings[]"
                           id="funding_{{count(filterEmptyArray(old('fundings'))) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="fundings_description">
                        Type into the empty field to add a new source of funding. / Remove a source of funding by
                        deleting the text of a field and clicking out of it.
                    </p>
                </div>
                <!-- Collaborating institutions -->
                <div class="FormInput">
                    <label class="FormLabel" for="institution">
                        Collaborating institutions
                    </label>
                    @foreach(filterEmptyArray(old('institutions')) as $institution)
                        <input class="Input institution"
                               name="institutions[]"
                               id="institution_{{$loop->iteration}}"
                               value="{{ $institution }}"
                               style="margin-bottom: 8px">
                        @error('institutions.' . $loop->index)
                        <p class="has-error" style="color: red" id="institution_{{$loop->iteration}}_error">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    @endforeach
                    <input class="Input institution"
                           name="institutions[]"
                           id="institution_{{count(filterEmptyArray(old('institutions'))) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="institutions_description">
                        Type into the empty field to add a new collaborating institution. / Remove a collaborating
                        institution by deleting the text of a field and clicking out of it.
                    </p>
                </div>
                <!-- Collaborating countries -->
                <div class="FormInput">
                    <label class="FormLabel" for="country">
                        Collaborating countries
                    </label>
                    @foreach(filterEmptyArray(old('countrys')) as $country)
                        <input class="Input country"
                               name="countrys[]"
                               id="country_{{$loop->iteration}}"
                               value="{{ $country }}"
                               style="margin-bottom: 8px">
                        @error('countrys.' . $loop->index)
                        <p class="has-error" style="color: red" id="country_{{$loop->iteration}}_error">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    @endforeach
                    <input class="Input country"
                           name="countrys[]"
                           id="country_{{count(filterEmptyArray(old('countrys'))) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="countrys_description">
                        Type into the empty field to add a new collaborating country. / Remove a collaborating country
                        by deleting the text of a field and clicking out of it.
                    </p>
                </div>
                <!-- Project leaders -->
                <div class="FormInput">
                    <label class="FormLabel" for="leaders">
                        Project leaders
                    </label>
                    <select class="multiselect"
                            id="leaders"
                            name="leaders[]"
                            multiple>
                        @foreach($ipzMembers as $ipzMember)
                            <option value="{{ $ipzMember->uid }}"
                                    @if(collect(old('leaders'))->contains($ipzMember->uid) || Auth::user()->uid == $ipzMember->uid) selected @endif>{{$ipzMember->first_name}} {{$ipzMember->last_name}}</option>
                        @endforeach
                    </select>
                    <p class="FormDescription">
                        This field is solely for access management and affiliation purposes. The project will be listed under all selected leaders and members. It will however not be displayed on the detailed project page.
                    </p>
                    @error('leaders')
                        <p class="has-error" style="color: red"">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                    @enderror
                </div>
                <!-- Project members -->
                <div class="FormInput">
                    <label class="FormLabel" for="members">
                        Project members
                    </label>
                    <select class="multiselect"
                            id="members"
                            name="members[]"
                            multiple>
                        @foreach($ipzMembers as $ipzMember)
                            <option value="{{ $ipzMember->uid }}"
                                    @if(collect(old('members'))->contains($ipzMember->uid)) selected @endif>{{$ipzMember->first_name}} {{$ipzMember->last_name}}</option>
                        @endforeach
                    </select>
                    <p class="FormDescription">
                        This field is solely for access management and affiliation purposes. The project will be listed under all selected leaders and members. It will however not be displayed on the detailed project page.
                    </p>
                </div>
                <!-- Contacts -->
                <div class="FormInput">
                    <label class="FormLabel">
                        Contacts
                    </label>
                    <select class="multiselect"
                            id="contacts"
                            name="contacts[]"
                            multiple>
                        @foreach($ipzMembers as $ipzMember)
                            <option value="{{ $ipzMember->uid }}.int"
                                    @if(collect(old('contacts'))->contains($ipzMember->uid . ".int")) selected @endif>{{$ipzMember->first_name}} {{$ipzMember->last_name}}</option>
                        @endforeach
                        @foreach($externalContacts as $externalContact)
                            <option value="{{ $externalContact->id }}.ext"
                                    @if(collect(old('contacts'))->contains($externalContact->id . ".ext")) selected @endif>{{ $externalContact->name }} ({{ $externalContact->organization }})</option>
                        @endforeach
                    </select>
                    <p class="FormDescription" id="contacts-description">
                        Select contacts from the list or add additional contacts by typing their name and hitting enter.
                    </p>
                </div>
                <!-- Keywords -->
                <div class="FormInput">
                    <label class="FormLabel" for="contributors">
                        Contributors
                    </label>
                    @foreach(filterEmptyArray(old('contributors')) as $contributor)
                        <input class="Input contributor"
                               name="contributors[]"
                               id="contributor_{{$loop->iteration}}"
                               value="{{ $contributor }}"
                               style="margin-bottom: 8px">
                        @error('contributors.' . $loop->index)
                        <p class="has-error" style="color: red" id="contributor_{{$loop->iteration}}_error">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    @endforeach
                    <input class="Input contributor"
                           name="contributors[]"
                           id="contributor_{{count(filterEmptyArray(old('contributors'))) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="contributors_description">
                        Type into the empty field to add a new contributor. / Remove a contributor by deleting the text of a
                        field and clicking out of it. / You may define roles by adding it in braces behind the name of the contributor. E.g. John Doe (Project Leader).
                    </p>
                </div>
                <!-- Transversal research priority -->
                <div class="FormInput">
                    <label class="FormLabel" for="transv_research_prios">Transversal Research Priorities</label>
                    <select class="multiselect" id="transv_research_prios" name="transv_research_prios[]" multiple>
                        @foreach($transvResearchPrios as $prio)
                            <option value="{{ $prio->id }}"
                                    @if(collect(old('transv_research_prios'))->contains($prio->id)) selected @endif>{{ $prio->english }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- research areas -->
                <div class="FormInput">
                    <label class="FormLabel" for="research_areas">Research Areas</label>
                    <select class="multiselect" id="research_areas" name="research_areas[]" multiple>
                        @foreach($researchAreas as $area)
                            <option value="{{ $area->id }}"
                                    @if(collect(old('research_areas'))->contains($area->id)) selected @endif>{{ $area->english }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Keywords -->
                <div class="FormInput">
                    <label class="FormLabel" for="keywords">
                        Keywords
                    </label>
                    @foreach(filterEmptyArray(old('keywords')) as $keyword)
                        <input class="Input keyword"
                               name="keywords[]"
                               id="keyword_{{$loop->iteration}}"
                               value="{{ $keyword }}"
                               style="margin-bottom: 8px">
                        @error('keywords.' . $loop->index)
                        <p class="has-error" style="color: red" id="keyword_{{$loop->iteration}}_error">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    @endforeach
                    <input class="Input keyword"
                           name="keywords[]"
                           id="keyword_{{count(filterEmptyArray(old('keywords'))) + 1}}"
                           style="margin-bottom: 8px">
                    <p class="FormDescription" id="keywords_description">
                        Type into the empty field to add a new keyword. / Remove a keyword by deleting the text of a
                        field and clicking out of it.
                    </p>
                </div>
            </div>
            <div class="FormButtons">
                <a href="@if(request()->session()->get('mode', 'user') == 'admin') {{route('admin.research')}} @else {{route('research.index')}} @endif" class="Button color-border-white size-large">
                    <span class="Button--inner">
                        Cancel
                    </span>
                </a>
                <button class="Button color-primary size-large" type="submit">
                    <span class="Button--inner">
                        Create
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-layout>

<script>
    $(document).ready(function () {

        // sets date range options
        $('#date_range').flatpickr({
            mode: 'range',
            dateFormat: 'l, J F Y'
        })

        // Initialize Selectize for manager select
        $('#leaders').selectize({
            closeAfterSelect: true,
            sortField: 'text',
            onChange: function () {
                // retrieve selected values
                let selectedValues = this.getValue()
                // When a manager is selected, remove that option from the member select
                for (const value of selectedValues) {
                    $('#members')[0].selectize.removeOption(value, true);
                }
            },
            onItemRemove: function (value) {
                if (value === '{{ Auth::user()->uid }}') {
                    customConfirm("You are about to remove yourself as a project leader. This will remove your access to this project. Are you sure you want to continue?")
                        .then(function(result) {
                            if (result) {
                                var text = $('#leaders')[0].selectize.options[value].text;
                                $('#leaders')[0].selectize.addOption({value: value, text: text});
                                $('#members')[0].selectize.addOption({value: value, text: text});
                            } else {
                                $('#leaders')[0].selectize.addItem(value);
                            }
                        })
                        .catch(function() {
                            $('#leaders')[0].selectize.addItem(value);
                        });
                } else {
                    var text = $('#leaders')[0].selectize.options[value].text;
                    $('#leaders')[0].selectize.addOption({value: value, text: text});
                    $('#members')[0].selectize.addOption({value: value, text: text});
                }
            }
        });

        // Initialize Selectize for member select
        $('#members').selectize({
            closeAfterSelect: true,
            sortField: 'text',
            onChange: function (values) {
                // retrieve selected values
                let selectedValues = this.getValue()
                // When a member is selected, remove that option from the manager select
                for (const value of selectedValues) {
                    $('#leaders')[0].selectize.removeOption(value, true);
                }

            },
            onItemRemove: function (value) {
                var text = $('#members')[0].selectize.options[value].text;
                $('#leaders')[0].selectize.addOption({value: value, text: text});
                $('#members')[0].selectize.addOption({value: value, text: text});
            }
        });

        // sets contact multiselect options
        $('#contacts').selectize({
            closeAfterSelect: true,
            sortField: 'text',
            create: function (input, callback) { // triggered when new contact is created

                // sets modal opening css styles
                function openModal() {
                    $('#emptyNameError').hide()
                    $('#emptyMailError').hide()
                    $('#invalidMailError').hide()
                    $('#duplicateMailError').hide()
                    $('#validationSpinner').hide()
                    $('#contactName').val(input);
                    $('#contactMail').val('');
                    $('#organization').val('');
                    $('#externalContactModal').css('display', 'block');
                    $('#contactName').focus();
                }

                // closes modal when conacel button was clicked, sets focus back to input form
                function closeModalAbort() {
                    $('#externalContactModal').css('display', 'none');
                    $('#externalContactForm').off('submit');
                    $('#closeModal').off('click');
                    $('#contacts-selectized').focus()
                    callback();
                }

                // closes modal on success, sets focus back to input form
                function closeModalSuccess() {
                    $('#externalContactModal').css('display', 'none');
                    $('#externalContactForm').off('submit');
                    $('#closeModal').off('click');
                    $('#contacts-selectized').focus()
                }

                openModal();

                // sets on click functionality on close button
                $('#closeModal').on('click', closeModalAbort);

                // handles form submits in modal
                $('#externalContactForm').on('submit', function (event) {
                    event.preventDefault();

                    // displays spinner
                    $('#validationSpinner').show();

                    // Get the entered contact name and email
                    const contactName = $('#contactName').val();
                    const contactEmail = $('#contactMail').val();
                    const organization = $('#organization').val();

                    // adds CSRF-Token to ajax request
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // makes ajax post request
                    $.ajax({
                        url: "{{ route('externalContact.createJSON') }}",
                        method: 'POST',
                        data: {
                            name: contactName,
                            email: contactEmail,
                            organization: organization
                        },
                        success: function (response) { // success message
                            // checks if provided contact details are valid
                            if (response.isValid) {
                                // hides spinner
                                $('#validationSpinner').hide();
                                // closes modal
                                closeModalSuccess();
                                // adds external contact to list
                                callback({value: response.contactId + ".ext", text: response.contactName + " (" + response.organization + ")"})
                            } else {
                                // sets empty name error
                                if (response.errorMessages.emptyNameError) {
                                    $('#emptyNameError').show()
                                } else {
                                    $('#emptyNameError').hide()
                                }

                                // sets empty email error
                                if (response.errorMessages.emptyMailError) {
                                    $('#emptyMailError').show()
                                } else {
                                    $('#emptyMailError').hide()
                                }

                                // sets invalid email error
                                if (response.errorMessages.invalidMailError) {
                                    $('#invalidMailError').show()
                                } else {
                                    $('#invalidMailError').hide()
                                }

                                // sets duplicate email error
                                if (response.errorMessages.duplicateMailError) {
                                    $('#duplicateMailError').show()
                                } else {
                                    $('#duplicateMailError').hide()
                                }
                                // hides spinner
                                $('#validationSpinner').hide();
                            }
                        },
                        error: function (err) {
                            // logs ajax error
                            console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                        }
                    });
                });
            }
        });

        // list of classnames for multiple inputs
        let classNames = [
            'summary_url',
            'zora_id',
            'project_url',
            'funding',
            'institution',
            'country',
            'contributor',
            'keyword'
        ]

        for (let className of classNames) {
            $(document).on('input', `.${className}`, function (event) {
                // retrieves all research-area input fields
                const inputs = $(`.${className}`);
                // retrieves current empty last input
                const lastInput = inputs.last();
                // checks if user types into currently last input
                if (this === lastInput[0] && lastInput.val().trim() !== '') {
                    // creates new empty input
                    let newField = `<input name=${className}s[]" class="Input ${className}" id="${className}_${inputs.length + 1}" style="margin-bottom: 8px;">`;
                    // appends it to list but not movable list
                    $(`#${className}s_description`).before(newField)
                }
            });

            // listens to loss of focus on media-competence inputs
            $(document).on('blur', `.${className}`, function (event) {
                // stores input that lost focus in variable
                const currentInput = $(this);
                // stores the potential error
                const inputError = $(`#${currentInput.attr('id')}_error`);
                // retrieves all research-area inputs
                const inputs = $(`.${className}`);

                // checks if current input is empty and whether unfocused input is the last one in the list
                if (currentInput.val().trim() === '' && inputs.length > 1 && currentInput[0] !== inputs.last()[0]) {
                    // animates removal of input
                    currentInput.css('transition', 'opacity 0.5s ease-out').css('opacity', '0');

                    setTimeout(() => {
                        currentInput.remove();
                        inputError.remove();
                    }, 500);
                }
            });
        }

        // sets config for multiselect
        $('#transv_research_prios').selectize({
            closeAfterSelect: true,
            sortField: 'text',
        });

        // sets config for multiselect
        $('#research_areas').selectize({
            closeAfterSelect: true,
            sortField: 'text',
        });

        // manually trigger onChange to remove already selected old data from list
        $('#leaders')[0].selectize.trigger('change');
        $('#members')[0].selectize.trigger('change');

        function showModal(message) {
            $('#confirmationMessage').text(message);
            $('#confirmModal').css('display', 'block');
        }

        function closeModal() {
            $('#confirmModal').css('display', 'none');
            $('#confirmButton').off('click');
            $('#cancelButton').off('click');
        }

        function customConfirm(message) {
            return new Promise(function (resolve, reject) {
                showModal(message);

                $('#confirmButton').on('click', function () {
                    closeModal();
                    resolve(true);
                });

                $('#cancelButton').on('click', function () {
                    closeModal();
                    resolve(false);
                });
            });
        }

    });

</script>
