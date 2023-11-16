<section class="Intro">
    <div class="Intro--inner">
        <div class="Intro--top">
            <h1 class="Intro--title richtext">
                Bitte melden Sie sich an, um fortzufahren.
            </h1>
        </div>
    </div>
</section>
<section class="ContentArea">
    <form class="Form js-Form" id="IPZ Master Login" method="POST" action="/authenticate">
        @csrf
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
                    Passwort
                </label>
                <input type="password" class="Input" name="password"/>
                @error('password')
                <p class="has-error">
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
