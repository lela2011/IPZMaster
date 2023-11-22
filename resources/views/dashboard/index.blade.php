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
            @include('dashboard.navigation')
        </section>
    @else
       @include('auth.login')
    @endauth
</x-layout>


