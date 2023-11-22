<section class="Intro">
    <div class="Intro--inner">
        <div class="Intro--top">
            <h1 class="Intro--title richtext">
                Please sign in with your UZH-Account to continue.
            </h1>
        </div>
    </div>
</section>
<section class="ContentArea">
    <form class="Form js-Form" id="IPZ Master Login" method="POST" action="/authenticate">
        @csrf <!-- Prevents cross site scripting attacks -->
        <div class="Form--body">
            <div class="FormInput">
                <label class="FormLabel" for="uid">
                    UZH-Shortname
                </label>
                <input type="text" class="Input" name="uid" value="{{old('uid')}}"/>
                @error('uid')
                <p class="has-error" style="color: red">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="password">
                    Password
                </label>
                <input type="password" class="Input" name="password"/>
                @error('password')
                <p class="has-error" style="color: red">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="FormButtons">
                <button class="Button color-primary size-large" type="submit">
                    <span class="Button--inner">
                        Login
                    </span>
                </button>
            </div>
        </div>
    </form>
</section>
