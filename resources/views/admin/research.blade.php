<x-layout>
    <x-confirm-modal/>
    <div class="ContentArea">
        <x-flash-message/>
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to Admin Panel
            </a>
            <a href="{{ route('research.create') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Create Research Project
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Research Projects
            </h2>
        </div>
        <form class="Form js-Form" method="GET" id="Personal Data Edit" action="{{route('admin.research')}}">
            <div class="Form--header">
                <h2 id="expandSurface" class="Form--title" style="cursor: pointer">Filter (click to expand)</h2>
            </div>
            <div id="expandable" style="display: none">
                <div class="FormInput">
                    <label class="FormLabel" for="title">Title</label>
                    <input class="Input" name="title" id="title" value="{{ old('title', optional($filters)['title']) }}">
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="user_id">Person</label>
                    <select class="selectFilter" name="user_id" id="user_id">
                        <option value="">All</option>
                        @foreach ($people as $person)
                            <option value="{{ $person->uid }}" @if($person->uid == optional($filters)['user_id']) selected @endif>{{ $person->first_name }} {{ $person->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="FormButtons">
                    <a href="{{route('admin.research')}}" class="Button color-border-white size-large">
                        <span class="Button--inner">
                            Reset Filters
                        </span>
                    </a>
                    <button class="Button color-primary size-large" type="submit">
                        <span class="Button--inner">Filter</span>
                    </button>
                </div>
            </div>
        </form>
        @if($projects->isNotEmpty())
            <section class="ZoraPublications js-ZoraPublications">
                <ul class="ZoraPublications--list" data-level="1">
                    @foreach($projects as $project)
                        <li>
                            <div class="ZoraCitation">
                                <span class="ZoraCitation--author">
                                    {{ \Carbon\Carbon::parse($project->start_date)->format('l, jS F Y') }} until {{ \Carbon\Carbon::parse($project->end_date)->format('l, jS F Y') }}
                                </span>
                                <a class="Link size-small" href="{{ route('research.show', $project->id) }}">
                                    {{ $project->title }}
                                </a>
                                @if ($project->researchAreas()->pluck('english')->isNotEmpty())
                                    <span class="ZoraCitation--publication">
                                        <b style="font-weight: bold;">Research Areas:</b> {{ $project->researchAreas()->pluck('english')->implode(', ') }}
                                    </span>
                                @endif
                                @if ($project->transversalResearchPrios()->pluck('english')->isNotEmpty())
                                    <span class="ZoraCitation--publication">
                                        <b style="font-weight: bold;">Transversal Research Priorities:</b> {{ $project->transversalResearchPrios()->pluck('english')->implode(', ') }}
                                    </span>
                                @endif
                                <div style="display: flex; margin-top: 16px">
                                    <a class="edit quickaction" href=" {{ route('research.edit', $project->id) }} ">
                                        <span class="material-icons" style="margin-right: 8px">
                                            edit
                                        </span>
                                        <span>
                                            edit
                                        </span>
                                    </a>
                                    <span class="divider"></span>
                                    <div style="flex: 1; display: flex; justify-content:center">
                                        <form data-project="{{ $project->title }}" class="deleteForm" action="{{ route('research.destroy', $project->id) }}" method="POST" style="width: 100%">
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
                        </li>
                    @endforeach
                </ul>
                {{ $projects->withQueryString()->links('pagination.uzh-pagination-en') }}
            </section>
        @else
            @if ($filters)
                <div class="TextImage TextImage--inner TextImage--content richtext">
                    <p>
                        There are no research projects for the given filter yet. Consider creating a new research project.
                    </p>
                </div>
            @else
                <div class="TextImage TextImage--inner TextImage--content richtext">
                    <p>
                        There are no research projects yet. Consider creating a new research project.
                    </p>
                </div>
            @endif
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
            var name = form.data('project');
            // opens confirmation modal
            customConfirm('Are you sure you want to delete the project <b style="font-weight: bold;">' + name + '</b>?')
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

        $('#expandSurface').on('click', function() {
            $('#expandable').slideToggle(300);

            if ($(this).text() == 'Filter (click to expand)') {
                $(this).text('Filter (click to collapse)');
            } else {
                $(this).text('Filter (click to expand)');
            }
        });

        $('.selectFilter').selectize({
            create: false,
            sortField: 'text'
        });
    });
</script>
