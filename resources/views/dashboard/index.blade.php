<x-layout>
    @auth
        <section class="Intro">
            <div class="Intro--inner">
                <div class="Intro--top">
                    <h1 class="Intro--title richtext">
                        Welcome {{Auth::user()->first_name}} {{Auth::user()->last_name}}!
                    </h1>
                </div>
            </div>
        </section>
        <section class="ContentArea">
            <div class="TextImage TextImage--content richtext">
                <p>
                    <span style="font-weight: bold;">Notice: </span>
                    By using this website, you acknowledge that all information entered may be publicly visible. It is your responsibility to ensure the accuracy and maintenance of your submitted data.
                </p>
            </div>
            @include('dashboard.navigation')
        </section>
    @else
       @include('auth.login')
    @endauth
</x-layout>


