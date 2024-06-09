<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.employment-type.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                Return to List
            </a>
            <a href="{{ route('admin.employment-type.edit', $employmentType->id) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Employment Type
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $employmentType->english }}
            </h2>
            <div class="TextImage--inner">
                <div class="TextImage--text richtext">
                    <h4>
                        Name - German (Plural):
                    </h4>
                    <p>
                        {{ $employmentType->german}}
                    </p>
                    <h4>
                        Name - English (Singular):
                    </h4>
                    <p>
                        {{ $employmentType->singular }}
                    </p>
                    <h4>
                        Base URL - English:
                    </h4>
                    <a href="{{ $employmentType->url_english }}" target="_blank">
                        {{ $employmentType->url_english }}
                    </a>
                    <h4>
                        Base URL - German:
                    </h4>
                    <a href="{{ $employmentType->url_german }}" target="_blank">
                        {{ $employmentType->url_german }}
                    </a>
                    <h4>
                        Has Personal Page:
                    </h4>
                    <p>
                        {{ $employmentType->has_personal_page ? 'Yes' : 'No' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
