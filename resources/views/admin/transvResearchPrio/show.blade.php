<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.transversal-research-prio.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to List
            </a>
            <a href="{{ route('admin.transversal-research-prio.edit', $prio->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Transversal Research Priority
                <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
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
