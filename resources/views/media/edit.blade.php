<x-layout>
    <div class="ContentArea">
        <x-back>
            <x-slot:route>
                {{ route('media.show', $user->uid) }}
            </x-slot:route>
            Return to media page
        </x-back>
        <x-flash-message/>
        <form class="Form js-Form" method="POST" id="Personal Data Edit" action="{{route('media.update', $user->uid)}}">
            @method('PUT')
            @csrf
            <div class="FormInput" id="media-competences">
                <label class="FormLabel">
                    Media Competences
                </label>
                <select class="multiselect" name="media_competences[]" id="media_competences" multiple>
                    @foreach($allCompetences as $competence)
                        <option value="{{$competence->id}}" @if (collect(old('media_competences', $userCompetences))->contains($competence->id)) selected @endif>{{$competence->name}}</option>
                    @endforeach
                </select>
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
                <a href="{{route('media.show', $user->uid)}}" class="Button color-border-white size-large">
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

        $('#media_competences').selectize({
            closeAfterSelect: true,
            sortField: 'text',
            create: function(input, callback) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('competence.createJSON') }}",
                    method: "POST",
                    data: {
                        competence: input
                    },
                    success: function (response) {
                        if (response.success) {
                            callback({value: response.competence, text: response.competence});
                        }
                    },
                    error: function (err) {
                        // logs ajax error
                        console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                    }
                });
            }
        });
    });
</script>
