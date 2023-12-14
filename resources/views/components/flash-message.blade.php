@if(session()->has('message'))
    <div x-data="{show: true}"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         class="TextImage "
         style="text-align: center">
        <p style="
            background: #6ab04c;
            padding: 16px;
            border-radius: 16px;
            font-weight: bold;
        ">
            {{session('message')}}
        </p>
    </div>
@endif
@if(session()->has('errorMessage'))
    <div x-data="{show: true}"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         class="TextImage "
         style="text-align: center">
        <p style="
            background: red;
            text-color: white;
            padding: 16px;
            border-radius: 16px;
            font-weight: bold;
        ">
            {{session('errorMessage')}}
        </p>
    </div>
@endif
