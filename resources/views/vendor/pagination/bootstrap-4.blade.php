@if ($paginator->hasPages())
<ul class="pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->currentPage() > 1)
    <li class="page-item">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
    </li>
    @else
    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
    @endif

    {{-- First Page Link --}}
    @if ($paginator->currentPage() > 2)
    <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
    @endif

    {{-- "Three Dots" Separator --}}
    @if($paginator->currentPage() > 3)
    <li class="page-item disabled"><span class="page-link">...</span></li>
    @endif

    {{-- Pagination Window --}}
    @foreach(range(1, $paginator->lastPage()) as $i)
    @if ($i === $paginator->currentPage())
    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
    @elseif ($i === $paginator->currentPage() - 1 || $i === $paginator->currentPage() + 1)
    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
    @endif
    @endforeach

    {{-- "Three Dots" Separator --}}
    @if($paginator->currentPage() < $paginator->lastPage() - 2)
        <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        {{-- Last Page Link --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 1)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
            @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
</ul>
@endif