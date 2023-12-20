<x-layout>
    <div class="ContentArea">
        <x-confirm-modal />
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            @if (request()->session()->get('mode', 'user') == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                    <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                    Return to Admin Panel
                </a>
            @else
                <a href="{{ route('home') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                    <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                    Return to Dashboard
                </a>
            @endif
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Files
            </h2>
        </div>
        <form class="Form js-Form" method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="FormInput">
                <label class="FormLabel" for="file">Upload new File</label>
                <input class="File--input" type="file" accept=".pdf,.doc,.docx" name="file" id="file">
                @error('file')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                @enderror
            </div>
            <div class="FormButtons">
                <button class="Button color-primary size-large" type="submit">
                    <span class="Button--inner">
                        Upload
                    </span>
                </button>
            </div>
        </form>
        @if( $files->isNotEmpty())
            <div class="TextImage">
                <div class="TextImage--content richtext">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">File Name</th>
                                <th scope="col" colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td>{{ $file->filename }}</td>
                                    <td>
                                        <button class="copy-link edit" data-url="{{ $file->url }}">
                                            Copy Link
                                        </button>
                                    </td>
                                    <td>
                                        <form class="deleteForm" action="{{ route('file.destroy', $file->id) }}" method="POST"  data-name="{{ $file->filename }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="TextImage">
                <div class="TextImage--content richtext">
                    <p>No files uploaded yet.</p>
                </div>
            </div>
        @endif
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
            // retrieves name of project
            var name = form.data('name');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the file <b style="font-weight: bold;">' + name + '</b>? Ensure to remove the link to the file from your personal page.')
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

        // copies link to clipboard
        $('.copy-link').on('click', function() {
            // retrieves link
            const link = $(this).data('url');
            // copies link to clipboard
            navigator.clipboard.writeText(link);

            // changes button text to 'Copied!' for 2 seconds
            $(this).html('Copied!');
            setTimeout(() => {
                $(this).html('Copy Link');
            }, 1000);
        })
    });
</script>
