<h3 class="visuallyhidden">Pagination</h3>
<nav class="Pagination js-Pagination" aria-label="Pagination" style="margin-left: 4px">
    <div class="Pagination--body">
        @if ($paginator->onFirstPage())
            <span class="Pagination--button prev"></span>
        @else
            <a class="Pagination--button prev js-Pagination--prev"
                href="{{ $paginator->previousPageUrl() }}">
                <span class="visuallyhidden">Vorherige Seite</span>
            </a>
        @endif

        <div class="Pagination--current">
            <span class="js-Pagination--current">{{ $paginator->currentPage() }}</span>
            of
            <span class="js-Pagination--max">{{ $paginator->lastPage() }}</span>
        </div>

        @if ($paginator->hasMorePages())
            <a class="Pagination--button next js-Pagination--next" href="{{ $paginator->nextPageUrl() }}">
                <span class="visuallyhidden">Nächste Seite</span>
            </a>
        @else
            <span class="Pagination--button next"></span>
        @endif
    </div>
</nav>
