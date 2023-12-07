@extends('admission::admin.layouts.admin')

@section('subtitle', 'Informasi Footer - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Informasi Footer</li>
    <li class="breadcrumb-item active">Data Informasi Footer</li>
@endsection

@section('section')
    <div class="section">
        <h3 class="mb-1">Kelola data Informasi Footer</h3>
        <div class="mb-2">Tambah dan ubah Informasi Footer.</div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0">Data Informasi Footer</h5>
                    <span class="text-muted">Menampilkan data Informasi Footer</span>
                    <br>
                </div>
                <div class="card-body bg-light border-top">
                    <form class="form-block" id="search-form" action="{{ route('admission.admin.footer_information.index') }}" method="GET">
                        <input type="hidden" name="limit" value="{{ request('l', 10) }}">
                        <div class="form-inline">
                            <select class="form-control my-1 mr-sm-2" name="aid">
                                <option value="">Semua jenis</option>
                                @foreach($type as $key => $item)
                                    <option value="{{ $item }}" @if(request('aid') == $item) selected @endif>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="my-1 mr-sm-2">
                                <button type="submit" class="btn btn-success mr-2">
                                    <i class="mdi mdi-magnify"></i> Cari
                                </button>
                                <a class="btn btn-primary" href="{{ route('admission.admin.footer_information.create', request()->all()) }}">
                                    <i class="mdi mdi-add"></i> Tambah Informasi Footer
                                </a>
                                <a class="btn btn-secondary" href="{{ route('admission.admin.footer_information.index') }}">
                                    <i class="mdi mdi-refresh"></i> Refresh
                                </a>

                            </div>
                        </div>
                    </form>
                </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ strtoupper($item->type) }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($item->status)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="py-2 align-middle border-left text-center" nowrap>
                                            <a class="btn btn-warning btn-sm" href="{{ route('admission.admin.footer_information.edit', ['footerInformation' => $item->id]) }}"><i class="mdi mdi-pencil"></i></a>
                                            <form class="form-block form-confirm d-inline" action="{{ route('admission.admin.footer_information.destroy', ['footerInformation' => $item->id]) }}" method="POST"> @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="mdi mdi-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted px-4">
                                            Tidak ada data informasi footer
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>


</div>
@endsection
