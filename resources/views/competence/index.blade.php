<x-layout>
    <x-confirm-modal/>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to dashboard
            </a>
        </div>
        @if ($competences->isEmpty())
            @if ($filter)
                <form class="Form js-Form" method="GET" action="{{route('competence.index')}}">
                    <div class="FormInput">
                        <div style="display: flex">
                            <input class="Input" name="filter" id="filter" value="{{ old('filter', $filter) }}" placeholder="Filter competences by name">
                            <button class="Button color-primary size-large" type="submit" style="margin-left: 8px">
                            <span class="Button--inner">
                                Search
                            </span>
                            </button>
                        </div>
                        @error('filter')
                        <p class="has-error" style="color: red">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    </div>
                </form>
                <div class="TextImage TextImage--inner TextImage--content richtext">
                    <p>
                        There are no competences under the name "{{ $filter }}" yet. Consider creating a new competence.
                    </p>
                </div>
            @else
                <div class="TextImage TextImage--inner TextImage--content richtext">
                    <p>
                        There are no competences yet. Consider creating a new one.
                    </p>
                </div>
            @endif
        @else
        <form class="Form js-Form" method="GET" action="{{route('competence.index')}}">
            <div class="FormInput">
                <div style="display: flex;">
                    <input class="Input" name="filter" id="filter" value="{{ old('filter', $filter) }}" placeholder="Filter competences by name">
                    <button class="Button color-primary size-large" type="submit" style="margin-left: 8px">
                    <span class="Button--inner">
                        Search
                    </span>
                    </button>
                </div>
                @error('filter')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
                </p>
                @enderror
            </div>
        </form>
        @endif
        @if($competences->isNotEmpty())
            <div class="TextImage">
                <div class="contactGrid">
                    @foreach ($competences as $competence)
                        <div class="contactGridItem">
                            <div style="display: flex; white-space: no-wrap; justify-content: space-between">
                                <form class="editForm" style="display: none; flex: 1;" method="POST" action="{{ route('competence.update', $competence->id) }}">
                                    @method("PUT")
                                    @csrf
                                    <input class="Input" name="competence">
                                    <button type="submit" style="display: flex; justify-content: center; align-items: center">
                                        <span class="material-icons" style="margin-left: 8px; margin-right: 8px;">
                                            check
                                        </span>
                                    </button>
                                </form>
                            </div>
                            <span class="LinkList--text competenceSpan">
                                {{ $competence->name }}
                            </span>
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
                                    <form data-competence="{{ $competence->name }}" class="deleteForm" method="POST" style="width: 100%" action="{{ route('competence.destroy', $competence->id) }}">
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
                    @endforeach
                </div>
            </div>
        @endif
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
            // retrieves name of project
            var name = form.data('competence');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the competence <b style="font-weight: bold;">' + name + '</b>?')
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
            // retrieves edit form of competence
            var form = $(this).closest('.contactGridItem').find('form.editForm');
            // retrieves input of form
            var input = $(this).closest('.contactGridItem').find('input.Input');
            // retrieves span of competence
            var span = $(this).closest('.contactGridItem').find('span.competenceSpan');

            // sets value of input to value of span
            input.val(span.text().trim())

            // toggles visibility of edit form and span
            form.css('display', 'flex');
            span.css('display', 'none');
            $(this).css('display', 'none');
            $(this).siblings('.cancel').css('display', 'flex');
        });

        // listens for edit button click
        $('.cancel').on('click', function() {
            // retrieves edit form of competence
            var form = $(this).closest('.contactGridItem').find('form.editForm');
            // retrieves span of competence
            var span = $(this).closest('.contactGridItem').find('span.competenceSpan');

            // toggles visibility of edit form and span
            form.css('display', 'none');
            span.css('display', 'flex');
            $(this).css('display', 'none');
            $(this).siblings('.edit').css('display', 'flex');
        });
    });
</script>
