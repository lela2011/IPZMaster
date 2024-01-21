<x-layout>
    <x-confirm-modal/>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to Admin Panel
            </a>
            <a href="{{ route('admin.transversal-research-prio.create') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Create Transversal Research Priority
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Employment Types
            </h2>
        </div>
        <div class="TextImage">
            <div class="contactGrid">
                @foreach ($prios as $prio)
                    <a class="contactGridItem" href="{{ route('admin.transversal-research-prio.show', $prio->id) }}" style="display: flex; justify-content: space-between">
                        <span class="LinkList--text" style="flex: 1">
                            {{ $prio->english }}
                        </span>
                        <form class="deleteForm" action="{{ route('admin.transversal-research-prio.delete', $prio->id) }}" data-prio="{{ $prio->english }}" method="POST">
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
            var name = form.data('prio');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the transversal research priority <b style="font-weight: bold;">' + name + '</b>?')
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
