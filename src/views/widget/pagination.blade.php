@if ($paginator->lastPage() > 1)
<ul class="pagination pagination-round float-sm-right">
    <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->url($paginator->currentPage() - 1) }}"><i class="fa fa-angle-left"></i> Previous</a>
    </li>
    @for ($i = max(1, $paginator->currentPage() - 5); $i <= min($paginator->lastPage(), $paginator->currentPage() + 5); $i++)
        <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
            <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        </li>
    @endfor
    <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->url($paginator->currentPage() + 1) }}" >Next <i class="fa fa-angle-right"></i></a>
    </li>
</ul>
@endif