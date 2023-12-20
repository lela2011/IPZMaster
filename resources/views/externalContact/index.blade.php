<x-layout>
    <x-confirm-modal/>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to Dashboard
            </a>
            <a href="{{ route('externalContact.create') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Create a new External Contact
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        @if ($externalContacts->isEmpty())
            @if ($filter)
                <form class="Form js-Form" method="GET" action="{{route('externalContact.index')}}">
                    <div class="FormInput">
                        <div style="display: flex">
                            <input class="Input" name="filter" id="filter" value="{{ old('filter', $filter) }}" placeholder="Filter external contacts by name">
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
                        There are no external contacts under the name "{{ $filter }}" yet. Consider creating a new contact.
                    </p>
                </div>
            @else
                <div class="TextImage TextImage--inner TextImage--content richtext">
                    <p>
                        There are no external contacts yet. Consider creating a new one.
                    </p>
                </div>
            @endif
        @else
        <form class="Form js-Form" method="GET" action="{{route('externalContact.index')}}">
            <div class="FormInput">
                <div style="display: flex">
                    <input class="Input" name="filter" id="filter" value="{{ old('filter', $filter) }}" placeholder="Filter external contacts by name">
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
        @if($externalContacts->isNotEmpty())
            <div class="TextImage">
                <div class="contactGrid">
                    @foreach ($externalContacts as $contact)
                        <div class="contactGridItem">
                            <span class="LinkList--text">
                                {{ $contact->organization }}
                            </span>
                            <br>
                            <span class="LinkList--text" style="font-weight: bold;">
                                {{ $contact->name }}
                            </span>
                            <br>
                            <span class="LinkList--text">
                                {{ $contact->email }}
                            </span>
                            <div style="display: flex; margin-top: 16px">
                                <a class="edit quickaction" href=" {{ route('externalContact.edit', ['externalContact' => $contact->id]) }} ">
                                    <span class="material-icons" style="margin-right: 8px">
                                        edit
                                    </span>
                                    <span>
                                        edit
                                    </span>
                                </a>
                                <span class="divider"></span>
                                <div style="flex: 1; display: flex; justify-content:center">
                                    <form data-name="{{ $contact->name }}" data-mail="{{ $contact->email }}" data-organization="{{ $contact->organization }}" class="deleteForm" action="{{ route('externalContact.destroy', ['externalContact' => $contact->id]) }}" method="POST" style="width: 100%">
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
            var name = form.data('name');
            var email = form.data('mail');
            var organization = form.data('organization');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the external contact <b style="font-weight: bold;">' + name + ' (' + organization + ' | ' + email + ')</b>?')
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
    });
</script>
