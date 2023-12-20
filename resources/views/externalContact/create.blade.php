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
                    <label class="FormLabel" for="organization">
                        Organization
                    </label>
                    <input class="Input" id="organization" name="organization" value="{{ old('organization') }}">
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
