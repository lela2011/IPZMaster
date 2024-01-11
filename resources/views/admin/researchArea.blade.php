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
                        <div class="contactGridItem" style="display: flex; flex-direction: column;">
                            <a href="{{ route('research-area.show', $researchArea->id) }}" style="height: 100%">
                                <span class="LinkList--text" style="font-weight: bold; flex-grow: 1">
                                    {{ $researchArea->english }}
                                </span>
                            </a>
                            <span class="LinkList--text">
                                Managed by:
                            </span>
                            @if($researchArea->manager()->exists())
                                <div style="display: flex;">
                                    <div style="flex-grow: 1;">
                                        <span class="LinkList--text manager-span">{{ $researchArea->manager->first_name }} {{ $researchArea->manager->last_name }}</span>
                                        <div style="display: flex; flex-grow: 1">
                                            <form class="editForm" style="display: none; flex: 1;" method="POST" action="{{ route('admin.research-area.updateManager', $researchArea->id) }}">
                                                @method("PATCH")
                                                @csrf
                                                <select class="manager-uid-input" name="manager_uid">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->uid }}" @if($researchArea->manager_uid == $user->uid) selected @endif>{{ $user->first_name }} {{ $user->last_name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="inline-quickaction submit" style="display: flex; justify-content: center; align-items: center">
                                                    <span class="material-icons" style="margin-left: 8px; margin-right: 8px;">
                                                        check
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <button class="edit inline-quickaction">
                                        <span class="material-icons" style="margin-right: 8px">
                                            edit
                                        </span>
                                    </button>
                                    <button class="cancel inline-quickaction" style="display: none">
                                        <span class="material-icons" style="margin-right: 8px">
                                            close
                                        </span>
                                    </button>
                                </div>
                            @else
                                <span class="LinkList--text">-</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-layout>
<script>
    $(document).ready(function() {

        // listens for edit button click
        $('.edit').on('click', function() {
            // retrieves edit form of competence
            var form = $(this).closest('.contactGridItem').find('form.editForm');
            // retrieves input of form
            var input = $(this).closest('.contactGridItem').find('input.Input');
            // retrieves span of competence
            var span = $(this).closest('.contactGridItem').find('span.manager-span');

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
            var span = $(this).closest('.contactGridItem').find('span.manager-span');

            // toggles visibility of edit form and span
            form.css('display', 'none');
            span.css('display', 'flex');
            $(this).css('display', 'none');
            $(this).siblings('.edit').css('display', 'flex');
        });

        $('.manager-uid-input').selectize({});
    });
</script>

