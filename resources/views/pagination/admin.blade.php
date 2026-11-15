@if ($paginator->hasPages())
    <nav class="admin-pagination" aria-label="Navigasi halaman">
        <p class="admin-pagination__summary">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
        </p>
        <div class="admin-pagination__links">
            @if ($paginator->onFirstPage())
                <span class="admin-pagination__link is-disabled" aria-disabled="true">
                    <i class="ri-arrow-left-s-line" aria-hidden="true"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="admin-pagination__link" rel="prev" aria-label="Halaman sebelumnya">
                    <i class="ri-arrow-left-s-line" aria-hidden="true"></i>
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="admin-pagination__link is-disabled" aria-hidden="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="admin-pagination__link is-current" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="admin-pagination__link" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="admin-pagination__link" rel="next" aria-label="Halaman berikutnya">
                    <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                </a>
            @else
                <span class="admin-pagination__link is-disabled" aria-disabled="true">
                    <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
