<x-layout>
    <x-confirm-modal/>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to Admin Panel
            </a>
            <a href="{{ route('admin.employment-type.create') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Create Employment Type
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Employment Types
            </h2>
        </div>
        <div class="TextImage">
            <div class="contactGrid">
                @foreach ($employmentTypes as $employmentType)
                    <a class="contactGridItem" href="{{ route('admin.employment-type.show', $employmentType->id) }}" style="display: flex; justify-content: space-between">
                        <span class="LinkList--text" style="flex: 1">
                            {{ $employmentType->english }}
                        </span>
                        <form class="deleteForm" action="{{ route('admin.employment-type.delete', $employmentType->id) }}" data-type="{{ $employmentType->english }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="delete quickaction" style="flex: 0" type="submit">
                                <span class="material-icons" style="margin-right: 8px;">
                                    delete
                                </span>
                            </button>
                        </form>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="TextImage" style="display: flex">
            <a href="{{ route('admin.employment-type.updateOrder') }}" class="Button color-border-white size-large" style="margin-left: auto;">
                Update Order
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
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
            var name = form.data('type');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the employment type <b style="font-weight: bold;">' + name + '</b>?')
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
