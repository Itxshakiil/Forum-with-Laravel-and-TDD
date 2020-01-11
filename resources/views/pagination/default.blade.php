@if ($paginator->hasPages())
<div class="flex justify-center">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="p-2" aria-hidden="true" aria-disabled="true" aria-label="@lang('pagination.previous')">&lsaquo;</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="text-blue-500 p-2" rel="prev"
        aria-label="@lang('pagination.previous')">&lsaquo;</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <span aria-disabled="true">{{ $element }}</span>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="p-2" aria-current="page">{{ $page }}</span>
    @else
    <a class="text-blue-500 p-2" href="{{ $url }}">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page divnk --}}
    @if ($paginator->hasMorePages())
    <a class="text-blue-500 p-2" href="{{ $paginator->nextPageUrl() }}" rel="next"
        aria-label="@lang('pagination.next')">&rsaquo;</a>
    @else
        <span class="p-2" aria-hidden="true" aria-disabled="true" aria-label="@lang('pagination.next')">&rsaquo;</span>
    @endif
</div>
@endif