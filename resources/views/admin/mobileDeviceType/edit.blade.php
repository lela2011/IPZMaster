<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('mobile-device-type.index') }}" class="Button color-border-white size-large"
                style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to List
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Update the Mobile Device Type: {{ $mobileDeviceType->name }}
            </h2>
        </div>
        <form class="js-Form Form" action="{{ route('mobile-device-type.update', $mobileDeviceType->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="Form--body">
                <div class="FormInput">
                    <label class="FormLabel" for="name">Name</label>
                    <input class="Input" type="text" name="name" id="name" value="{{ old('name', $mobileDeviceType->name) }}">
                    @error('name')
                    <p class="has-error" style="color: red">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="FormButtons">
                    <a href="{{route('mobile-device-type.index')}}" class="Button color-border-white size-large">
                        <span class="Button--inner">
                            Cancel
                        </span>
                    </a>
                    <button class="Button color-primary size-large" type="submit">
                        <span class="Button--inner">Update</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>
