<x-layout>
    <x-confirm-modal/>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.employment-type.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Employment Type Order
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('admin.employment-type.updateOrder.submit') }}" method="POST">
            @csrf
            <div class="Form--header">
                <h2 class="Form--title">
                    Edit the order of the employment types
                </h2>
                <p class="Form--description">
                    - Changes will be visible on the research area pages on ipz.uzh.ch<br>
                    - Drag the employment type to the desired order and click on "Update Order"
                </p>
            </div>
            <div style="display: flex">
                <div>
                    @for ($i = 1; $i <= count($employmentTypes); $i++)
                        <p class="LinkList--text" style="flex: 1; padding: 8px; margin: 16px 8px 16px 0px; text-align: right;">
                            {{ $i }}.
                        </p>
                    @endfor
                </div>
                <div id="order" style="flex: 10">
                    @foreach ($employmentTypes as $employmentType)
                        <div class="employment-type-card">
                            <input type="hidden" name="order[]" value="{{ $employmentType->id }}">
                            <span class="LinkList--text" style="flex: 1">
                                {{ $employmentType->english }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="FormButtons">
                <a href="{{ route('admin.employment-type.index') }}" class="Button color-border-white size-large">
                    <span class="Button--inner">
                        Cancel
                    </span>
                </a>
                <button class="Button color-primary size-large" type="submit">
                    <span class="Button--inner">
                        Update Order
                    </span>
                </button>
            </div>
        </form>
    </section>
</x-layout>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    $draggable = $('#order')[0]
    new Sortable($draggable, {
        animation: 150,
    });
</script>
