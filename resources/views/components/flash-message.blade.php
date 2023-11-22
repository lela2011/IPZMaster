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
