<x-layout>
    <div class="ContentArea">
        <x-confirm-modal />
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.inventory.dashboard') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to Inventory Dashboard
            </a>
            <a href="{{ route('computer-type.create') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                Add new Computer Type
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Computer Types
            </h2>
        </div>
        <div class="TextImage">
            <div class="TextImage--content richtext" style="overflow-x: scroll">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">Actions</th>
                            <th scope="col">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($computerTypes as $computerType)
                            <tr>
                                <td style="text-align: center">
                                    <a href="{{ route('computer-type.edit', $computerType->id) }}" class="quickaction-anchor edit">
                                        <span class="material-icons">
                                            edit
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <form class="deleteForm" data-name="{{ $computerType->name }}" action="{{ route('computer-type.destroy', $computerType->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete">
                                            <span class="material-icons">
                                                delete
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td>{{ $computerType->name }}</td>
                            </tr>
                        @endforeach
                        @if ($computerTypes->isEmpty())
                            <tr>
                                <td colspan="3">No Computer Types found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $computerTypes->withQueryString()->links('pagination.uzh-pagination-en') }}
        </div>
    </div>
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
            // retrieves name of computer
            var name = form.data('name');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the computer type <b style="font-weight: bold;">' + name + '</b>?')
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
