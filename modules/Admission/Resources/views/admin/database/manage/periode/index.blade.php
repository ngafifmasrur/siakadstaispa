@extends('admission::admin.layouts.admin')

@section('subtitle', 'Periode Penerimaan - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Periode Penerimaan</li>
    <li class="breadcrumb-item active">Data Periode Penerimaan</li>
@endsection

@section('section')
    <div class="section">
        <h3 class="mb-1">Kelola data Periode Penerimaan</h3>
        <div class="mb-2">Mengubah status periode.</div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="mb-0 py-1"> Data Periode </h5>
                </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Status Publish</th>
                                    <th>Ubah Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admission as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name.' '.$item->period->name }}</td>
                                        <td>{{ $item->period->year }}</td>
                                        <td>{{ $item->open ? 'Buka' : 'Tutup' }}</td>
                                        <td>{{ $item->published ? 'Published' : 'Unpublished' }}</td>
                                        <td class="py-2 align-middle border-left text-center" nowrap>
                                            <a class="btn btn-warning btn-sm" href="{{ route('admission.admin.database.manage.periode.edit', ['periode' => $item->id]) }}"><i class="mdi mdi-pencil"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted px-4">
                                            Tidak ada data periode
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
@endsection