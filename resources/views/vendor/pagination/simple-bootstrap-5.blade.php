@if ($paginator->hasPages())
  <nav role="navigation" aria-label="Pagination Navigation">
    <ul class="pagination">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true">
          <span class="page-link">Atrás</span>
        </li>
      @else
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
            Atrás
          </a>
        </li>
      @endif

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a>
        </li>
      @else
        <li class="page-item disabled" aria-disabled="true">
          <span class="page-link">Siguiente</span>
        </li>
      @endif
    </ul>
  </nav>
@endif
