@extends('admission::admin.layouts.admin')

@section('subtitle', 'Data kamar - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Pangkalan data</li>
    <li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item active">Data kamar</li>
@endsection

@section('section')
    <div class="section">
        <h3 class="mb-1">Kelola data kamar</h3>
        <div class="mb-2">Menambah, mengubah, menghapus data kamar.</div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0">Pencarian</h5>
                </div>
                <div class="card-body border-top">
                    <form class="form-block" id="search-form" action="{{ route('admission.admin.database.manage.rooms.index') }}" method="GET">
                        <div class="form-group">
                            <label>Area</label>
                            <select class="form-control" name="area">
                                @foreach($areas as $i => $area)
                                    <option value="{{ $i }}" @if(request('area') == $i) selected @endif> {{ $area }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-0">   
                            <button type="submit" class="btn btn-success mr-2"><i class="mdi mdi-magnify"></i> Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body p-3">
                    @if(request('area') > -1)
                        <a href="{{ route('admission.admin.database.manage.rooms.create', request()->all()) }}" class="btn btn-success btn-sm float-right">Tambah kamar</a>
                    @endif
                    <h5 class="mb-0 py-1"> Data kamar </h5>
                </div>
                @if(request('area') > -1)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama kamar</th>
                                    <th>Area</th>
                                    <th>Kapasitas</th>
                                    <th>Terisi</th>
                                    <th>Keterangan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rooms as $room)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $room->name }}</td>
                                        <td>{{ $room->sex_name }}</td>
                                        <td>{{ $room->quota }}</td>
                                        <td>{{ $room->registrants_count }}</td>
                                        <td>
                                            @if($room->quota == $room->registrants_count)
                                                <span class="badge badge-success badge-pill">Sudah penuh</span>
                                            @else
                                                <span class="badge badge-warning badge-pill">Tersisa</span>
                                            @endif
                                        </td>
                                        <td class="py-2 align-middle border-left text-center" nowrap>
                                            <a class="btn btn-warning btn-sm" href="{{ route('admission.admin.database.manage.rooms.edit', ['room' => $room->id]) }}"><i class="mdi mdi-pencil"></i></a>
                                            @if($room->registrants_count)
                                                <button type="button" class="btn btn-secondary btn-sm btn-disabled" disabled="disabled"><i class="mdi mdi-trash-can"></i></button>
                                            @else
                                                <form class="form-block form-confirm d-inline" action="{{ route('admission.admin.database.manage.rooms.destroy', ['room' => $room->id]) }}" method="POST"> @csrf @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"><i class="mdi mdi-trash-can"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted px-4">
                                            Tidak ada data kamar
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card-body text-muted border-top">
                        Silahkan lakukan pencarian terlebih dahulu
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection