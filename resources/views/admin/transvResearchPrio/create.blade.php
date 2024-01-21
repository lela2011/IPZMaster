<x-layout>
    <x-confirm-modal/>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.transversal-research-prio.create') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to List
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Create new Employment Type
            </h2>
        </div>
        <form class="Form js-Form" method="POST" action="{{route('admin.transversal-research-prio.store')}}">
            @csrf
            <div class="Form--header">
                <h2 class="Form--title">
                    Fill in this form to create a new transversal research priority.
                </h2>
                <p class="Form--description">
                    - All fields must be filled
                </p>
            </div>
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="english">
                        Name - English
                    </label>
                    <input class="Input" name="english" id="english"
                           value="{{ old('english') }}">
                    @error('english')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Type the English name of the transversal research prioirty.
                    </p>
                </div>
                <div class="FormInput">
                    <label class="FormLabel" for="german">
                        Name - German
                    </label>
                    <input class="Input" name="german" id="german"
                           value="{{ old('german') }}">
                    @error('german')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                    <p class="FormDescription">
                        Type the German name of the transversal research prioirty.
                    </p>
                </div>
                <div class="FormButtons">
                    <a href="{{ route('admin.transversal-research-prio.create') }}" class="Button color-border-white size-large">
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
            </div>
        </form>
    </section>
</x-layout>

