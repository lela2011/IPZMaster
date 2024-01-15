<x-layout>
    <x-confirm-modal/>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to Admin Panel
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Research Area
            </h2>
        </div>
        @if($researchAreas->isNotEmpty())
            <div class="TextImage">
                <div class="contactGrid">
                    @foreach ($researchAreas as $researchArea)
                        <div class="contactGridItem" style="display: flex; flex-direction: column; justify-content: space-between">
                            <div>
                                <span class="LinkList--text">
                                    ID: {{ $researchArea->id }}
                                </span>
                                <br
                                <a href="{{ route('research-area.show', $researchArea->id) }}">
                                    <span class="LinkList--text" style="font-weight: bold;">
                                        {{ $researchArea->english }}
                                    </span>
                                </a>
                            </div>
                            <div>
                                <span class="LinkList--text">
                                    Managed by:
                                </span>
                                <div style="display: flex; white-space: no-wrap; justify-content: space-between">
                                    <form data-manager="{{ $researchArea->manager->uid ?? '' }}" class="editForm" style="display: none; flex: 1;" method="POST" action="{{ route('admin.research-area.updateManager', $researchArea->id) }}">
                                        @csrf
                                        @method("PATCH")
                                        <select class="manager-uid-input" name="manager_uid">
                                            <option value="">-</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->uid }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                            @endforeach
                                            @if($researchArea->manager)
                                                <option value="{{ $researchArea->manager->uid }}" selected>{{ $researchArea->manager->first_name }} {{ $researchArea->manager->last_name }}</option>
                                            @endif
                                        </select>
                                        <button type="submit" style="display: flex; justify-content: center; align-items: center">
                                            <span class="material-icons" style="margin-left: 8px; margin-right: 8px;">
                                                check
                                            </span>
                                        </button>
                                    </form>
                                </div>
                                @if($researchArea->manager)
                                    <span class="LinkList--text manager-span">{{ $researchArea->manager->first_name }} {{ $researchArea->manager->last_name }}</span>
                                @else
                                    <span class="LinkList--text manager-span">-</span>
                                @endif
                                <div style="display: flex; margin-top: 16px">
                                    <button class="edit quickaction">
                                        <span class="material-icons" style="margin-right: 8px">
                                            edit
                                        </span>
                                        <span>
                                            edit
                                        </span>
                                    </button>
                                    <button class="cancel quickaction" style="display: none">
                                        <span class="material-icons" style="margin-right: 8px">
                                            close
                                        </span>
                                        <span>
                                            cancel
                                        </span>
                                    </button>
                                    <span class="divider"></span>
                                    <div style="flex: 1; display: flex; justify-content:center">
                                        <form data-area="{{ $researchArea->english }}" class="deleteForm" method="POST" style="width: 100%" action="{{ route('admin.research-area.delete', $researchArea->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="delete quickaction" style="width: 100%">
                                                <span class="material-icons" style="margin-right: 8px">
                                                    delete
                                                </span>
                                                <span>
                                                    delete
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="TextImage">
                <div style="width: 100%; height: 1px; background-color:rgba(0,0,0,0.08)"></div>
            </div>
        @endif
        <form class="Form js-Form" method="POST" action="{{ route('admin.research-area.create') }}">
            @csrf
            <div class="Form--header">
                <h2 class="Form--title">
                    Create a new research area.
                </h2>
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="english">
                    Research Area Name - English
                </label>
                <input class="Input" name="english" id="english" value="{{ old('english') }}">
                @error('english')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
                </p>
                @enderror
                <p class="FormDescription">
                    Please enter the english name of the research area.
                </p>
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="german">
                    Research Area Name - German
                </label>
                <input class="Input" name="german" id="german" value="{{ old('german') }}">
                @error('german')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
                </p>
                @enderror
                <p class="FormDescription">
                    Please enter the german name of the research area.
                </p>
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="url_english">
                    Link - English
                </label>
                <input class="Input" name="url_english" id="url_english" value="{{ old('url_english') }}">
                @error('url_english')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
                </p>
                @enderror
                <p class="FormDescription">
                    Please enter the German IPZ-Link to the research area.
                </p>
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="url_german">
                    Link - German
                </label>
                <input class="Input" name="url_german" id="url_german" value="{{ old('url_german') }}">
                @error('url_german')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
                </p>
                @enderror
                <p class="FormDescription">
                    Please enter German the IPZ-Link to the research area.
                </p>
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="manager_uid">
                    Manager
                </label>
                <select name="manager_uid" id="manager_uid" value="{{ old('manager_uid') }}">
                    <option value="">-</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->uid }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
                @error('manager_uid')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
                </p>
                @enderror
                <p class="FormDescription">
                    Please enter the manager of the research area.
                </p>
            </div>
            <div class="FormButtons">
                <button class="Button color-primary size-large" type="submit">
                    <span class="Button--inner">
                        Create
                    </span>
                </button>
            </div>
        </form>
    </section>
</x-layout>
<script>
    $(document).ready(function() {

        // opens confirmation modal
        function showModal(message) {
            $('#confirmationMessage').html(message);
            $('#confirmModal').css('display', 'block');
        }

        // closes confirmation modal and removes listeners
        function closeModal() {
            $('#confirmModal').css('display', 'none');
            $('#confirmButton').off('click');
            $('#cancelButton').off('click');
        }

        // creates custom confirm modal by using promises
        function customConfirm(message) {
            return new Promise(function (resolve, reject) {
                // opens modal
                showModal(message);

                // attaches listeners to buttons
                $('#confirmButton').on('click', function () {
                    // closes modal
                    closeModal();
                    // returns confirmation
                    resolve(true);
                });

                $('#cancelButton').on('click', function () {
                    // closes modal
                    closeModal();
                    // returns rejection
                    resolve(false);
                });
            });
        }

        // listens for delete button click
        $('.delete').on('click', function() {
            // retrieves form of clicked button
            var form = $(this).closest('.deleteForm');
            // retrieves name of research area
            var name = form.data('area');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the research area <b style="font-weight: bold;">' + name + '</b>?')
                .then(function (result) {
                    // if confirmed, submits form
                    if (result) {
                        form.off('submit', handleFormSubmission).submit();
                        form.on('submit', handleFormSubmission);
                    }
                });
        });

        // prevents form from submitting when confirmation modal is open
        function handleFormSubmission(event) {
            event.preventDefault();
        }

        // attaches listener to form
        $('.deleteForm').on('submit', handleFormSubmission);

        // listens for edit button click
        $('.edit').on('click', function() {
            // retrieves edit form of research area
            var form = $(this).closest('.contactGridItem').find('form.editForm');
            // retrieves id of research area
            var managerUid = form.data('manager');
            console.log(managerUid);
            // retrieves select of form
            var select = $(this).closest('.contactGridItem').find('select.manager-uid-input')[0].selectize;
            console.log(select);
            // retrieves span of research area
            var span = $(this).closest('.contactGridItem').find('span.manager-span');

            // sets value of input to value of span

            // toggles visibility of edit form and span
            form.css('display', 'flex');
            select.setValue(managerUid, false);
            span.css('display', 'none');
            $(this).css('display', 'none');
            $(this).siblings('.cancel').css('display', 'flex');
        });

        // listens for edit button click
        $('.cancel').on('click', function() {
            // retrieves edit form of competence
            var form = $(this).closest('.contactGridItem').find('form.editForm');
            // retrieves span of competence
            var span = $(this).closest('.contactGridItem').find('span.manager-span');

            // toggles visibility of edit form and span
            form.css('display', 'none');
            span.css('display', 'flex');
            $(this).css('display', 'none');
            $(this).siblings('.edit').css('display', 'flex');
        });

        $('.manager-uid-input').selectize({});
        $('#manager_uid').selectize({});
    });
</script>

