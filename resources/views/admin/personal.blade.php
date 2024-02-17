<x-layout>
    <section class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                <i class="fa fa-arrow-left" style="margin-right: 8px; vertical-align: bottom"></i>
                Return to Admin Data
            </a>
            <form method="POST" action="{{ route('admin.sync-users')}}">
                @csrf
                <button class="Button color-border-white size-large" style="margin-bottom: 8px" type="submit">
                    Sync Users
                    <i class="fa fa-arrow-right" style="margin-left: 8px; vertical-align: bottom"></i>
                </button>
            </form>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                Personal Information
            </h2>
        </div>
        @if ($users->isEmpty())
            @if ($filter)
                <form class="Form js-Form" method="GET" action="{{route('admin.personal')}}">
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
                        There are no users. Something went wrong.
                    </p>
                </div>
            @endif
        @else
        <form class="Form js-Form" method="GET" action="{{route('admin.personal')}}">
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
                        <a href="{{ route('personal.show', $user->uid) }}" class="contactGridItem">
                            <div style="display: flex; white-space: nowrap; flex: 1; justify-content: space-between">
                                <div>
                                    @if($user->adminLevel > 0)
                                        <span class="LinkList--text">
                                            Admin, Level: {{ $user->adminLevel }}
                                        </span>
                                        <br>
                                    @else
                                        <span class="LinkList--text">
                                            User
                                        </span>
                                        <br>
                                    @endif
                                    <span class="LinkList--text" style="font-weight: bold;">
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </span>
                                    <br>
                                    <span class="LinkList--text">
                                        {{ $user->email }}
                                    </span>
                                </div>
                                @if(Auth::user()->adminLevel > 1)
                                    @if ($user->adminLevel == 0)
                                        <form style="align-self: center" method="POST" action="{{ route('admin.promote', $user->uid) }}">
                                            @csrf
                                            <button style="display: flex;" title="Click to promote user to admin" type="submit">
                                                <span class="material-icons" style="font-size: 36px;">
                                                    key
                                                </span>
                                            </button>
                                        </form>
                                    @endif
                                    @if($user->adminLevel == 1)
                                        <form style="align-self: center" method="POST" action="{{ route('admin.demote', $user->uid) }}">
                                            @csrf
                                            <button style="display: flex;" title="Click to promote user to admin" type="submit">
                                                <span class="material-icons" style="font-size: 36px;">
                                                    key_off
                                                </span>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-layout>
