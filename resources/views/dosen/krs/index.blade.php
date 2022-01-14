@extends('layouts.app')
@section('title', 'Perwalian')

@section('content')

<x-header>
    Perwalian
</x-header>

<x-card-table>
    <x-slot name="title">Perwalian</x-slot>
    <x-slot name="button">
        <button {{ $semester_mahasiswa->status_krs == 'Diverifikasi' ? 'disabled' : ''}} class="btn btn-app btn-sm btn-primary btn_setujui" data-text="Anda yakin ingin menghapus data ini ?" data-status="Setujui" data-route="{{ route('dosen.krs.update_status', [ 'id_mahasiswa' => $id_mahasiswa, 'id_semester' => $id_semester]) }}" ><i class="fa fa-plus mr-2"></i>Terima</button>
        <button {{ $semester_mahasiswa->status_krs == 'Ditolak' ? 'disabled' : ''}} class="btn btn-app btn-sm btn-danger btn_setujui" data-text="Anda yakin ingin menghapus data ini ?" data-status="Tolak" data-route="{{ route('dosen.krs.update_status', [ 'id_mahasiswa' => $id_mahasiswa, 'id_semester' => $id_semester]) }}" ><i class="fa fa-plus mr-2"></i>Revisi</button>
    </x-slot>

    <x-datatable 
    :route="route('dosen.krs.data_index', [$id_mahasiswa, $id_semester])" 
    :table="[
        ['title' => 'No.', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false', 'width' => '10'],                            
        {{-- ['title' => 'Program Studi', 'data' => 'prodi', 'name' => 'prodi', 'classname' => 'text-left'], --}}
        ['title' => 'NIM Mahasiswa', 'data' => 'nim_mahasiswa', 'name' => 'nim_mahasiswa', 'classname' => 'text-left'],
        ['title' => 'Nama Mahasiswa', 'data' => 'mahasiswa', 'name' => 'mahasiswa', 'classname' => 'text-left'],
        ['title' => 'Mata Kuliah', 'data' => 'matkul', 'name' => 'matkul','classname' => 'text-left'],
        ['title' => 'Kelas', 'data' => 'kelas', 'name' => 'kelas','classname' => 'text-left'],
        ['title' => 'Ruangan', 'data' => 'ruangan', 'name' => 'ruangan','classname' => 'text-left'],
        ['title' => 'Jadwal', 'data' => 'jadwal', 'name' => 'jadwal'],
        {{-- ['title' => 'Status', 'data' => 'status', 'name' => 'status'], --}}
        {{-- ['title' => 'Aksi', 'data' => 'action', 'orderable' => 'false', 'searchable' => 'false'], --}}
    ]"
    />

</x-card-table>

<x-modal.approve/>

@endsection