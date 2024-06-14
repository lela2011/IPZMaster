<x-layout>
    <div class="ContentArea">
        <form class="Form js-Form" method="POST" action="{{ route('externalContact.store') }}">
            @csrf
            <div class="Form--header">
                <h2 class="Form--title">
                    Create a new External Contact
                </h2>
            </div>
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="name">
                        Name
                    </label>
                    <input class="Input" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="email">
                        Mail
                    </label>
                    <input class="Input" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="url">
                        URL - German
                    </label>
                    <input class="Input" id="url" name="url" value="{{ old('url') }}">
                    @error('url')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="url_en">
                        URL - English
                    </label>
                    <input class="Input" id="url_en" name="url_en" value="{{ old('url_en') }}">
                    @error('url_en')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="organization">
                        Organization
                    </label>
                    <input class="Input" id="organization" name="organization" value="{{ old('organization') }}">
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="research_areas">
                        Research Areas
                    </label>
                    <select id="research_areas" name="research_areas[]" multiple>
                        @foreach($researchAreaOptions as $researchAreaOption)
                            <option value="{{ $researchAreaOption->id }}"
                                    @if(collect(old('research_areas'))->contains($researchAreaOption->id))
                                        selected
                                @endif
                            >{{ $researchAreaOption->english }}</option>
                        @endforeach
                    </select>
                    <p class="FormDescription">
                        Select one or multiple research areas.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="employment_type">
                        Employment Type
                    </label>
                    <select class="Select" id="employment_type" name="employment_type">
                        <option value=""></option>
                        @foreach($employmentTypes as $employmentType)
                            <option value="{{ $employmentType->id }}"
                                @if(old('employment_type') == $employmentType->id)
                                        selected
                                @endif
                            >{{ $employmentType->singular }}</option>
                        @endforeach
                    </select>
                    @error('employment_type')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Select your employment type for the research areas you work for.
                    </p>
                </div>
            </div>
            <div class="FormButtons">
                <a href="{{ route('externalContact.index') }}" class="Button color-border-white size-large">
                    <span class="Button--inner">
                        Cancel
                    </span>
                </a>
                <button class="Button color-primary size-large" type="submit">
                    <span class="Button--inner">
                        Create
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-layout>

<script>
    // Executes when the document is fully loaded
    $(document).ready(function () {

        // Initializes 'research_areas' selectize
        $('#research_areas').selectize({
            closeAfterSelect: true,
            sortField: 'text',
        });
    });
</script>
