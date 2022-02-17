@extends('layouts.app')
@section('title', 'Pengisian Nilai')

@section('content')
<x-header>
    Form Pengisian Nilai Peserta Kuliah
</x-header>

<x-card-table>
    <x-slot name="title">Daftar Peserta</x-slot>
    <x-slot name="button">
        <a class="btn btn-app btn-sm btn-success" href="{{ route('dosen.pengisian_nilai.export', $kelas_kuliah->id_kelas_kuliah)}}"><i class="fa fa-print mr-2"></i>Unduh Nilai</a>
        <a class="btn btn-app btn-sm btn-primary add-form" data-url="{{ route('dosen.pengisian_nilai.import') }}" href="#"><i class="fa fa-upload mr-2"></i>Impor</a>
        <button class="btn btn-app btn-sm btn-primary" onclick="document.getElementById('nilai-form').submit();"><i class="fa fa-save mr-2"></i>Simpan</button>
    </x-slot>

    @if (Session::get('results'))
        <div class="alert alert" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <hr class="message-inner-separator">
            <ul>
                @foreach(Session::get('results') as $key => $item)
                @if ($item['error_code'] !== '0')
                <li class="text-danger">{{ $item['error_code'].' - '.$item['error_desc'] }}</li>
                @else
                <li class="text-success" style="color:#00C851!important">Berhasil Disimpan!</li>
                @endif
            @endforeach 
            </ul> 
        </div>
    @endif

    <x-table>
        <x-slot name="thead">
            <tr>
                <th class="text-center" style="width: 5%">NO</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th class="text-center" style="width: 15%">Nilai Akhir</th>
            </tr>
        </x-slot>

        <form action="{{ route('dosen.pengisian_nilai.store_nilai') }}" method="post" id="nilai-form">
            @csrf
            <input type="hidden" name="id_kelas_kuliah" value="{{ $kelas_kuliah->id_kelas_kuliah }}">
            <input type="hidden" name="id_prodi" value="{{ $kelas_kuliah->id_prodi }}">
            @foreach ($peserta as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->nim }}</td>
                <td>{{ $item->nama_mahasiswa }}</td>
                <td  class="text-center"><input class="form-control text-center" type="number" name="{{ $item->id_registrasi_mahasiswa }}" value="{{ $item->nilai_angka }}" min="0" max="100" required></td>
            </tr>
        @endforeach
        </form>
    </x-table>
</x-card-table>

<x-modal class="modal-form" id="modal-form">
    <x-slot name="title">Impor Nilai</x-slot>
    <x-slot name="modalPosition">modal-dialog-centered</x-slot>
    @csrf 
    @method('post')
    <div class="form-group row">
        <input type="hidden" name="id_kelas_kuliah" value="{{ $kelas_kuliah->id_kelas_kuliah }}">
        <input type="hidden" name="id_prodi" value="{{ $kelas_kuliah->id_prodi }}">
        <div class="form-group col-lg-12">
            <a class="btn btn-app btn-sm btn-success" href="{{ route('dosen.pengisian_nilai.template_import', $kelas_kuliah->id_kelas_kuliah)}}"><i class="fa fa-download mr-2"></i>Template Import</a> <br> <br>
            <label for="import_file">File Import* ( xlsx, xls )</label>
            {!! Form::file('import_file', null, ['class' => 'form-control '.($errors->has('import_file') ? 'is-invalid' : ''), 'id' => 'import_file']) !!}
            @error('import_file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Import</button>
    </x-slot>
</x-modal>

@endsection

@push('js')
    <script>
        $('.add-form').on('click', function () {
            $('.modal-form').modal('show');
            $('.modal-form form')[0].reset();
            $('[name=_method]').val('post');
            $('.modal-form form').attr('action', $(this).data('url'));
        });
    </script>
@endpush