<div class="card" onclick="location.href='{{ $route }}'">
    <div class="image-container">
        <img class="image"
            src="{{asset('images/' . $image )}}">
    </div>
    <div class="LinkList">
        <div class="LinkList--header">
            <h3 class="LinkList--title">
                {{ $slot }}
            </h3>
        </div>
        <div class="LinkList--content">
            <p class="LinkList--text">
                {{ $details }}
            </p>
        </div>
    </div>
</div>
