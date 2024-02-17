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
    @error('serverError')
        <div x-data="{show: true}"
             x-init="setTimeout(() => show = false, 6000)"
             x-show="show"
             class="TextImage "
             style="text-align: center">
            <p style="
            background: red;
            padding: 16px;
            border-radius: 16px;
            font-weight: bold;
            color: white;
        ">
                {{$message}}
            </p>
        </div>
    @enderror
    <form class="Form js-Form" id="IPZ Master Login" method="POST" action=" {{route('auth')}} ">
        @csrf <!-- Prevents cross site scripting attacks -->
        <div class="Form--body">
            <div class="FormInput">
                <label class="FormLabel" for="uid">
                    UZH-Shortname
                </label>
                <input type="text" class="Input" name="uid" value="{{old('uid')}}" autocomplete="username"/>
                @error('uid')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
                </p>
                @enderror
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="password">
                    Password
                </label>
                <input type="password" class="Input" name="password" autocomplete="current-password"/>
                @error('password')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
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
