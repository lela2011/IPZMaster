<x-iframe-layout>
    <h2 class="TextImage--title  richtext">Query our competence database</h2>
    <div class="TextImage--content richtext">
        <p>In order to find the most suitable expert on a specific topic, you can use the following search function to browse the expertise recorded by our institute members.</p>
    </div>
    <form class="Form iframe-form" action="{{ url()->current() }}" method="get">
        <div class="FormInput">
            <label class="FormLabel" for="filter">
                Competence
            </label>
            <select class="multiselect" id="filter" name="filter[]" multiple onchange="this.form.submit()">
                @foreach ($allCompetences as $competence)
                    <option value="{{ $competence->id }}" @if (collect($filter)->contains($competence->id)) selected @endif>
                        {{ $competence->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <noscript><input type="submit" value="Submit"></noscript>
    </form>
    <div class="TextImage--content richtext" style="margin-top: 8px">
        @foreach ($competences as $competence)
            <div style="border-bottom: 1px solid rgba(0, 0, 0, 0.08); padding-bottom: 1rem">
                <h3>
                    {{ $competence->name }}
                </h3>
                @foreach ($competence->users as $user)
                    <p>
                        {{ $user->first_name}} {{ $user->last_name }}
                    </p>
                    <ul>
                        @if ($user->media_mail)
                            <li>
                                <a href="mailto:{{ $user->email }}">
                                    E-Mail
                                </a>
                                ({{ $user->email }})
                            </li>
                        @endif
                        @if ($user->media_phone)
                            <li>
                                <a href="tel:{{ $user->phone }}">
                                    Phone
                                </a>
                                ({{ $user->phone }})
                            </li>
                        @endif
                        @if($user->media_secretariat)
                            <li>
                                <a href="mailto:sekretariat@ipz.uzh.ch">
                                    Secretariat
                                </a>
                                (sekretariat@ipz.uzh.ch)
                            </li>
                        @endif
                    </ul>
                @endforeach
            </div>
        @endforeach
    </div>
</x-iframe-layout>
<script>
    $(document).ready(function() {
        $('#filter').selectize({
            closeAfterSelect: true,
        });
    });
</script>
