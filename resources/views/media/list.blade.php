<x-layout>
    <div class="ContentArea">
        <x-back/>
        <x-flash-message/>
        <form class="Form js-Form" method="POST" id="Personal Data Edit" action="{{route('media.update')}}">
            @csrf
            <div class="FormInput" id="media-competences-fields">
                <label class="FormLabel">
                    Media Competences
                </label>
                @foreach(array_filter(old('media_competences', $userCompetences), fn ($value) => !is_null($value)) as $competence)
                    <input class="Input media-competences"
                           name="media_competences[]"
                           value="{{$competence}}"
                           list="competences"
                           id="competence_{{$loop->iteration}}"
                           style="margin-bottom: 8px">
                @endforeach
                <input class="Input media-competences"
                       name="media_competences[]"
                       value=""
                       list="competences"
                       id="competence_{{count($userCompetences) + 1}}"
                       style="margin-bottom: 8px">
                <p class="FormDescription" id="description">
                    Type into the empty field to add a new media competence. / Remove a media competence by deleting the text of a field and clicking out of it.
                </p>
                <datalist id="competences">
                    @foreach($allCompetences as $competence)
                        <option value="{{$competence->competence}}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="FormInput">
                <label class="FormLabel" for="contactOption">
                    Preferred Contact
                </label>
                <div class="Options js-OptionInput" id="contactOption">
                    <div class="OptionInput">
                        <input type="checkbox" id="media_mail" value="mail" name="contact_method[]" @if(in_array("mail", old('contact_method', $selectedContact), true)) checked @endif>
                        <label for="media_mail">
                            E-Mail
                        </label>
                    </div>
                    <div class="OptionInput">
                        <input type="checkbox" id="media_phone" value="phone" name="contact_method[]" @if(in_array("phone", old('contact_method', $selectedContact), true)) checked @endif>
                        <label for="media_phone">
                            Phone
                        </label>
                    </div>
                    <div class="OptionInput">
                        <input type="checkbox" id="media_secretariat" value="secretariat" name="contact_method[]" @if(in_array("secretariat", old('contact_method', $selectedContact), true)) checked @endif>
                        <label for="media_secretariat">
                            Secretariat
                        </label>
                    </div>
                    @error('contact_method')
                    <p class="has-error" style="color: red">
                        <small>
                            {{$message}}
                        </small>
                    </p>
                    @enderror
                </div>
            </div>
            <div class="FormButtons">
                <a href="{{route('home')}}" class="Button color-border-white size-large">
                    <span class="Button--inner">
                        Cancel
                    </span>
                </a>
                <button class="Button color-primary size-large" type="submit">
                    <span class="Button--inner">
                        Update
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-layout>

<script>
    $(document).ready(function () {
        // listens to inputs being made on the website
        $(document).on('input', '.media-competences', function(event) {
            // retrieves all research-area input fields
            const inputs = $('.media-competences');
            // retrieves current empty last input
            const lastInput = inputs.last();
            // checks if user types into currently last input
            if (this === lastInput[0] && lastInput.val().trim() !== '') {
                // creates new empty input
                const newField = `<input name="media_competences[]" class="Input media-competences" list="competences" id="competence_${inputs.length + 1}" style='margin-bottom: 8px;'>`;
                // appends it to list but not movable list
                $('#description').before(newField)
            }
        });

        // listens to loss of focus on media-competence inputs
        $(document).on('blur', '.media-competences', function(event) {
            // stores input that lost focus in variable
            const currentInput = $(this);
            // retrieves all research-area inputs
            const inputs = $('.media-competences');

            // checks if current input is empty and whether unfocused input is the last one in the list
            if (currentInput.val().trim() === '' && inputs.length > 1 && currentInput[0] !== inputs.last()[0]) {
                // animates removal of input
                currentInput.css('transition', 'opacity 0.5s ease-out').css('opacity', '0');

                setTimeout(() => {
                    currentInput.remove();
                }, 500);
            }
        });
    });
</script>
