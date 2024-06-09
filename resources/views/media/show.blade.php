<x-layout>
    <div class="ContentArea">
        <x-flash-message />
        <div class="TextImage" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            @if (request()->session()->get('mode', 'user') == 'admin')
                <a href="{{ route('admin.media') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                    <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                    Return to List
                </a>
            @else
                <a href="{{ route('home') }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                    <span class="material-icons" style="margin-right: 8px">arrow_back</span>
                    Return to Dashboard
                </a>
            @endif
            <a href="{{ route('media.edit', $user->uid) }}" class="Button color-border-white size-large" style="margin-bottom: 8px">
                Edit Press Information
                <span class="material-icons" style="margin-left: 8px">arrow_forward</span>
            </a>
        </div>
        <div class="TextImage">
            <h2 class="TextImage--title richtext">
                {{ $user->first_name }} {{ $user->last_name }}
            </h2>
            <div class="TextImage--inner">
                @if ($user->competences->isNotEmpty() || $user->media_mail || $user->media_phone || $user->media_secretariat)
                    <div class="TextImage--text richtext">
                        @if($user->competences->isNotEmpty())
                            <h4>
                                Competences:
                            </h4>
                            <ul>
                                @foreach ($user->competences as $competence)
                                    <li>
                                        {{ $competence->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if ($user->media_mail || $user->media_phone || $user->media_secretariat)
                            <h4>
                                Means of contact:
                            </h4>
                            <ul>
                                @if ($user->media_mail)
                                    <li>
                                        Email
                                    </li>
                                @endif
                                @if ($user->media_phone)
                                    <li>
                                        Phone
                                    </li>
                                @endif
                                @if ($user->media_secretariat)
                                    <li>
                                        Secretariat
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                @else
                    <div class="TextImage--text richtext">
                        <p>
                            Please edit your press information.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-layout>

