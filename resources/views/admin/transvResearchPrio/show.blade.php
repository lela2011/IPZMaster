<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.transversal-research-prio.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
            <a href="{{ route('admin.transversal-research-prio.edit', $prio->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Transversal Research Priority
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $prio->english }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    <h4>
                        Name - German:
                    </h4>
                    <p>
                        {{ $prio->german}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
