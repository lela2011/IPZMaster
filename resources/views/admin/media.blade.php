<x-layout>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to admin panel
            </a>
        </div>
        @if ($users->isEmpty())
            @if ($filter)
                <form class="Form js-Form" method="GET" action="{{route('admin.media')}}">
                    <div class="FormInput">
                        <div style="display: flex">
                            <input class="Input" name="filter" id="filter" value="{{ old('filter', $filter) }}" placeholder="Filter personal by name">
                            <button class="Button color-primary size-large" type="submit" style="margin-left: 8px">
                            <span class="Button--inner">
                                Search
                            </span>
                            </button>
                        </div>
                        @error('filter')
                        <p class="has-error" style="color: red">
                            <small>
                                {{$message}}
                            </small>
                        </p>
                        @enderror
                    </div>
                </form>
                <div class="TextImage TextImage--inner TextImage--content richtext">
                    <p>
                        There are no users under the name "{{ $filter }}".
                    </p>
                </div>
            @else
                <div class="TextImage TextImage--inner TextImage--content richtext">
                    <p>
                        There are no users. Something went wrong
                    </p>
                </div>
            @endif
        @else
        <form class="Form js-Form" method="GET" action="{{route('admin.media')}}">
            <div class="FormInput">
                <div style="display: flex">
                    <input class="Input" name="filter" id="filter" value="{{ old('filter', $filter) }}" placeholder="Filter personal by name">
                    <button class="Button color-primary size-large" type="submit" style="margin-left: 8px">
                    <span class="Button--inner">
                        Search
                    </span>
                    </button>
                </div>
                @error('filter')
                <p class="has-error" style="color: red">
                    <small>
                        {{$message}}
                    </small>
                </p>
                @enderror
            </div>
        </form>
        @endif
        @if($users->isNotEmpty())
            <div class="TextImage">
                <div class="contactGrid">
                    @foreach ($users as $user)
                        <a href="{{ route('media.show', $user->uid) }}" class="contactGridItem">
                            <span class="LinkList--text" style="font-weight: bold;">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </span>
                            <br>
                            <span class="LinkList--text">
                                {{ $user->email }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-layout>
