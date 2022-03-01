<div class="row">
    <div class="col-sm-6">
        <div class="form-group mb-sm-0">
            <div class="input-group">
                <select class="form-control" onchange="window.location.href = '{{ url()->current().'?limit=' }}' + this.value + '{{ '&'.http_build_query(array_merge(request()->except(['page', 'limit']))) }}'">
                    @foreach([5, 10, 25, 50] as $limit)
                        <option value="{{ $limit }}" @if($limit == request('limit', $paginator->perPage())) selected @endif>{{ $limit }} baris</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <span class="input-group-text">{{ $paginator->firstItem() ?? 0 }} - {{ $paginator->firstItem() + ($paginator->count() ?: 1) - 1 }} dari {{ $paginator->total() }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        @if ($paginator->hasPages())
            <div class="input-group mb-4 mb-sm-0">
                <div class="input-group-prepend">
                    <span class="input-group-text d-inline d-sm-none">Halaman</span>
                    @if ($paginator->onFirstPage())
                        <button class="btn btn-outline-secondary" disabled>&laquo;</button>
                        <button class="btn btn-outline-secondary" disabled>&lsaquo;</button>
                    @else
                        <a class="btn btn-outline-secondary text-success" href="{{ $paginator->url(1) }}">&laquo;</a>
                        <a class="btn btn-outline-secondary text-success" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
                    @endif
                </div>

                {{-- Pagination Elements --}}
                <select class="form-control" onchange="if(this.value != {{ $paginator->currentPage() }}) { location = this.value }">
                    @for($i = 1; $i <= $paginator->lastPage(); $i++ )
                        <option value="{{ $paginator->url($i) }}" @if($i == $paginator->currentPage()) selected @endif>{{ $i }}</option>
                    @endfor
                </select>

                <div class="input-group-append">
                    @if ($paginator->hasMorePages())
                        <a class="btn btn-outline-secondary text-success" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
                        <a class="btn btn-outline-secondary text-success" href="{{ $paginator->url($paginator->lastPage()) }}">&raquo;</a>
                    @else
                        <button class="btn btn-outline-secondary" disabled>&rsaquo;</button>
                        <button class="btn btn-outline-secondary" disabled>&raquo;</button>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>