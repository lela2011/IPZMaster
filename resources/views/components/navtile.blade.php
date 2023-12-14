<div class="card" onclick="location.href='{{ $route }}'">
    <div class="image-container">
        <img class="image"
            src="{{asset('images/' . $image )}}">
    </div>
    <div class="LinkList" style="box-shadow: none; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
        <div class="LinkList--header">
            <h3 class="LinkList--title">
                {{ $slot }}
            </h3>
        </div>
        <div class="LinkList--content" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
            <p class="LinkList--text">
                {{ $details }}
            </p>
        </div>
    </div>
</div>
