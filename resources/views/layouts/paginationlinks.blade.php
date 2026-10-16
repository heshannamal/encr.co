{{-- @if($paginator->hasPages())
<ul class="pagination pagina001">
  <!-- Previous Page Link -->
  @if($paginator->onFirstPage())
    <li class="page-item disabled"><a class="page-link"><i class="fa fa-arrow-left"></i></a></li>
  @else
    <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev"><i class="fa fa-arrow-left"></i></a></li>
  @endif

  <!-- Pagination Elements Here -->
  @php
    $maxPagesToShow = 10;
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
  @endphp

  <!-- Determine the starting and ending pages to display -->
  @php
    $startPage = max($currentPage - 5, 1);
    $endPage = min($startPage + 9, $lastPage);
  @endphp

  <!-- Show first pagination -->
  <li class="page-item"><a href="{{ $paginator->url(1) }}" class="page-link">1</a></li>
  <!-- Show ellipsis if necessary -->
  @if($startPage > 2)
    <li class="page-item disabled"><a class="page-link"><span>...</span></a></li>
  @endif

  <!-- Show up to 10 pages -->
  @for($i = $startPage + 1; $i <= $endPage - 1; $i++)
    @if($i == $currentPage)
      <li class="page-item active"><a class="page-link"><span>{{ $i }}</span></a></li>
    @else
      <li class="page-item"><a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a></li>
    @endif
  @endfor

  <!-- Show ellipsis if necessary -->
  @if($endPage < $lastPage - 1)
    <li class="page-item disabled"><a class="page-link"><span>...</span></a></li>
  @endif

  <!-- Show last pagination -->
  <li class="page-item"><a href="{{ $paginator->url($lastPage) }}" class="page-link">{{ $lastPage }}</a></li>

  <!-- Next Page Link -->
  @if($paginator->hasMorePages())
    <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="fa fa-arrow-right"></i></a></li>
  @else
    <li class="page-item disabled"><a class="page-link"><i class="fa fa-arrow-right"></i></a></li>
  @endif
</ul>
@endif --}}

<style>

/* =========================================================
   PAGINATION RESPONSIVE
   ========================================================= */

/* Desktop */
.pagination-mobile {
    display: none !important;
}

.pagination-desktop {
    display: flex !important;
}


/* Mobile */
@media (max-width: 767.98px) {

    .pagination-desktop {
        display: none !important;
    }

    .pagination-mobile {
        display: flex !important;
    }
    .page-item .page-link, .page-item span {
        font-size: 0.6rem;
    }
    .page-item .page-link, .page-item span {
        width: 25px;
        height: 25px;
    }
    .mobile_pagination_float {
        float: none !important;
    }

}

</style>

@if($paginator->hasPages())

    {{-- =====================================================
         DESKTOP PAGINATION
         ===================================================== --}}
    <ul class="pagination pagina001 pagination-desktop">

        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="page-link"
                   rel="prev">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </li>
        @endif


        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();

            $startPage = max($currentPage - 5, 1);
            $endPage = min($startPage + 9, $lastPage);
        @endphp


        {{-- First page --}}
        <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
            <a href="{{ $paginator->url(1) }}" class="page-link">
                1
            </a>
        </li>


        {{-- Left ellipsis --}}
        @if($startPage > 2)
            <li class="page-item disabled">
                <a class="page-link">
                    <span>...</span>
                </a>
            </li>
        @endif


        {{-- Pages --}}
        @for($i = max($startPage + 1, 2); $i <= min($endPage - 1, $lastPage - 1); $i++)

            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a href="{{ $paginator->url($i) }}" class="page-link">
                    {{ $i }}
                </a>
            </li>

        @endfor


        {{-- Right ellipsis --}}
        @if($endPage < $lastPage - 1)
            <li class="page-item disabled">
                <a class="page-link">
                    <span>...</span>
                </a>
            </li>
        @endif


        {{-- Last page --}}
        @if($lastPage > 1)
            <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                <a href="{{ $paginator->url($lastPage) }}" class="page-link">
                    {{ $lastPage }}
                </a>
            </li>
        @endif


        {{-- Next --}}
        @if($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="page-link"
                   rel="next">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </li>
        @endif

    </ul>



    {{-- =====================================================
         MOBILE PAGINATION - 5 PAGE NUMBERS
         ===================================================== --}}
    <ul class="pagination pagina001 pagination-mobile">

        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="page-link"
                   rel="prev">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </li>
        @endif


        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();

            /*
             * Display maximum 5 page numbers
             */

            $mobileStart = max($currentPage - 2, 1);
            $mobileEnd = min($mobileStart + 4, $lastPage);

            /*
             * If we are near the last page,
             * move the starting point backwards.
             */
            if (($mobileEnd - $mobileStart + 1) < 5) {
                $mobileStart = max($mobileEnd - 4, 1);
            }
        @endphp


        {{-- Left ellipsis --}}
        @if($mobileStart > 1)

            <li class="page-item">
                <a href="{{ $paginator->url(1) }}"
                   class="page-link">
                    1
                </a>
            </li>

            @if($mobileStart > 2)
                <li class="page-item disabled">
                    <a class="page-link">
                        <span>...</span>
                    </a>
                </li>
            @endif

        @endif


        {{-- Maximum 5 page numbers --}}
        @for($i = $mobileStart; $i <= $mobileEnd; $i++)

            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a href="{{ $paginator->url($i) }}"
                   class="page-link">
                    {{ $i }}
                </a>
            </li>

        @endfor


        {{-- Right ellipsis --}}
        @if($mobileEnd < $lastPage)

            @if($mobileEnd < $lastPage - 1)
                <li class="page-item disabled">
                    <a class="page-link">
                        <span>...</span>
                    </a>
                </li>
            @endif

            <li class="page-item">
                <a href="{{ $paginator->url($lastPage) }}"
                   class="page-link">
                    {{ $lastPage }}
                </a>
            </li>

        @endif


        {{-- Next --}}
        @if($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="page-link"
                   rel="next">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </li>
        @endif

    </ul>

@endif
