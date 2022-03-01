@extends('admission::admin.layouts.admin')

@section('subtitle', 'Kelola calon mahasiswa baru - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pangkalan data</li>
	<li class="breadcrumb-item">Kelola</li>
    <li class="breadcrumb-item active">Calon mahasiswa baru</li>
@endsection

@section('section')
	<div class="section">
	    <h3 class="mb-1">Kelola calon mahasiswa baru</h3>
	    <div class="mb-2">Menambah, mengubah, menghapus, serta mereset sandi calon mahasiswa.</div>
	</div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form class="form-block" id="search-form" action="{{ route('admission.admin.database.manage.registrants.index') }}" method="GET">
                <input class="d-none" type="checkbox" name="trash" @if(request('trash')) checked @endif value="1">
                <input type="text" name="limit" value="{{ request('limit', 5) }}" hidden>
                <div class="form-inline">
                    <div class="input-group my-1 mr-sm-2">
                        <input type="text" class="form-control" placeholder="Cari disini ..." name="search" value="{{ request('search', '') }}" autofocus size="50">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success"><i class="mdi mdi-magnify"></i></button>
                        </div>
                    </div>
                    @can('manageAdmissions', Admission::class)
                        {{-- <a class="btn btn-danger my-1 mr-sm-2" href="javascript:;" id="get-trashed"><i class="mdi mdi-eye"></i> Lihat data yang {{ request('trash') ? 'tidak' : '' }} dihapus</a> --}}
                    @endcan
                    <a class="btn btn-success my-1 mr-sm-2" href="{{ route('admission.admin.database.manage.registrants.create') }}"><i class="mdi mdi-plus-circle-outline"></i> Daftar baru</a>
                </div>
            </form>
        </div>
        @if(request('trash'))
            <div class="card-body border-top py-1 table-warning">
                <span class="text-danger"> Menampilkan data calon mahasiswa baru yang dihapus! </span>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <tbody>
                    @forelse($registrants as $registrant)
                        <tr class="{{ empty($registrant->special) ?: 'table-warning' }}">
                            <td width="75" nowrap>
                                <img class="img-fluid rounded" src="{{{ $registrant->avatar ? Storage::url($registrant->avatar) : asset('assets/img/img-blank-3-4.png') }}}" alt="" style="max-height: 100px;">
                            </td>
                            <td nowrap>
                                <a href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}"><strong>{{ $registrant->user->profile->full_name }}</strong></a> @if($registrant->special) <i class="mdi mdi-star"></i> @endif<br>
                                {{ $registrant->user->profile->sex_name.', '.$registrant->user->profile->pdob}} <br>
                                <strong>{{ $registrant->user->username }}</strong> @include('admission::includes.registrant-progress-badge', compact('registrant'))
                            </td>
                            <td nowrap>
                                <strong>Jalur pendaftaran</strong><br>
                                {{ $registrant->admission->full_name }} <br>
                                {{ $registrant->kd }}
                            </td>
                            <td class="py-2 align-middle border-left text-center" nowrap>
                                @if($registrant->trashed())
                                    @can('manageAdmissions', Admission::class)
                                        <form class="d-inline" method="POST" action="{{ route('admission.admin.database.manage.registrants.restore', ['registrant' => $registrant->id, 'next' => url()->full()]) }}"> @csrf @method('PUT')
                                            <button class="btn btn-success btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="mdi mdi-refresh"></i></button>
                                        </form>
                                    @endcan
                                    @can('manageAdmissions', Admission::class)
                                        <form class="d-inline" method="POST" action="{{ route('admission.admin.database.manage.registrants.kill', ['registrant' => $registrant->id, 'next' => url()->full()]) }}"> @csrf @method('PUT')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                    @endcan
                                @else
                                    @can('view', $registrant)
                                        <a class="btn btn-success btn-sm" href="{{ route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id]) }}"><i class="mdi mdi-eye"></i> <span class="d-none d-md-inline">Lihat detail</span></a>
                                    @endcan
                                    @can('manageAdmissions', Admission::class)
                                        <form class="d-inline" method="POST" action="{{ route('admission.admin.database.manage.registrants.specialize', ['registrant' => $registrant->id, 'next' => url()->full()]) }}"> @csrf @method('PUT')
                                            <button class="btn btn-info btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="mdi mdi-star"></i></button>
                                        </form>
                                    @endcan
                                    @can('repass', $registrant)
                                        <form class="d-inline" method="POST" action="{{ route('admission.admin.database.manage.registrants.repass', ['registrant' => $registrant->id]) }}"> @csrf @method('PUT')
                                            <button class="btn btn-warning btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="mdi mdi-lock-open"></i></button>
                                        </form>
                                    @endcan
                                    @can('delete', $registrant)
                                        <form class="d-inline" method="POST" action="{{ route('admission.admin.database.manage.registrants.destroy', ['registrant' => $registrant->id]) }}"> @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted px-4">
                                @if(request('search'))
                                    Pendaftar dengan pencarian "{{ request('search') }}" tidak ditemukan
                                @else
                                    Tidak ada data calon mahasiswa
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body border-top">
            {{ $registrants->appends(request()->all())->links() }}
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(() => {
            $('#get-trashed').click(() => {
                $('[name="trash"]').prop('checked', {!! request('trash') ? 0 : 1 !!})
                $('#search-form').submit();
            });
        });
    </script>
@endpush