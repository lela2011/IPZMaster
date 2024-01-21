<x-layout>
    <x-confirm-modal/>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.employment-type.index') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to List
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Employment Type
            </h2>
        </div>
        <form class="Form js-Form" method="POST" action="{{route('admin.employment-type.update', $employmentType->id)}}">
            @csrf
            @method('PATCH')
            <div class="Form--header">
                <h2 class="Form--title">
                    Fill in this form to edit the employment type {{ $employmentType->english }}.
                </h2>
                <p class="Form--description">
                    - All fields must be filled
                </p>
            </div>
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="english">
                        Name - English (Plural)
                    </label>
                    <input class="Input" name="english" id="english"
                           value="{{ old('english', $employmentType->english) }}">
                    @error('english')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Type the english name of the employment type in plural. E.g. "Professors". This will be used as subtitle in the employee section of a research area
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="german">
                        Name - German (Plural)
                    </label>
                    <input class="Input" name="german" id="german"
                           value="{{ old('german', $employmentType->german) }}">
                    @error('german')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Type the german name of the employment type in plural. E.g. "Professoren". This will be used as subtitle in the employee section of a research area
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="singular">
                        Name - English (Singular)
                    </label>
                    <input class="Input" name="singular" id="singular"
                           value="{{ old('singular', $employmentType->singular) }}">
                    @error('singular')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Type the english name of the employment type in singular. E.g. "Professor". This will be used in dropdowns.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="url_english">
                        Base URL - English
                    </label>
                    <input class="Input" name="url_english" id="url_english"
                           value="{{ old('url_english', $employmentType->url_english) }}">
                    @error('url_english')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Type the base url of the employment type. E.g. https://www.ipz.uzh.ch/en/people/external-lecturers/ for external lecturers. Remove the trailing '.html' and append a '/' at the end. This will be used to link to the employee in question.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="url_german">
                        Base URL - German
                    </label>
                    <input class="Input" name="url_german" id="url_german"
                           value="{{ old('url_german', $employmentType->url_german) }}">
                    @error('url_german')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Type the base url of the employment type. E.g. https://www.ipz.uzh.ch/de/personen/externe-dozierende/ for external lecturers. Remove the trailing '.html' and append a '/' at the end. This will be used to link to the employee in question.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="has_personal_page">
                        Personal Page
                    </label>
                    <div class="Options js-OptionInput">
                        <div class="OptionInput">
                            <input type="checkbox" id="has_personal_page" name="has_personal_page" value="1" @if(old('has_personal_page', $employmentType->has_personal_page)) checked @endif>
                            <label for="has_personal_page">
                                Yes
                            </label>
                        </div>
                    </div>
                    <p class="FormDescription">
                        Check this if the employment type has a personal page. E.g. external lecturers do not have a personal page.
                    </p>
                </div>
                <div class="FormButtons">
                    <a href="{{ route('admin.employment-type.index') }}" class="Button color-border-white size-large">
                        <span class="Button--inner">
                            Cancel
                        </span>
                    </a>
                    <button class="Button color-primary size-large" type="submit">
                        <span class="Button--inner">
                            Update
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </section>
</x-layout>

