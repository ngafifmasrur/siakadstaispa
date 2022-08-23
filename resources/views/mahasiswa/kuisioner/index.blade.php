@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container px-5">
    <div class="card">
        <div class="card-body p-5">
            <form action="{{ route('mahasiswa.kuisioner.store') }}" method="post">
                @csrf 
                @method('post')
                <div class="row justify-content-left">
                    @foreach ($data as $value )
                    <div class="col-lg-12 col-md-12 mb-5">
                        <input type="hidden" name="dosen_id" value="{{ $id_dosen }}">
                        <input type="hidden" name="matkul_id" value="{{ $id_matkul }}">
                        <input type="hidden" name="mahasiswa_id" value="{{ Auth::user()->id_mahasiswa }}">
                        <span class="h4">{{ $loop->iteration }}.</span>
                        <span class="h4 ml-2">{{ $value->kuesioner }}</span>
                        <div class="pilihan ml-5 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban{{ $value->id }}" id="jawaban{{ $value->id }}" value="sangat baik">
                                <label class="form-check-label h5" for="jawaban">
                                    Sangat Baik
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban{{ $value->id }}" id="jawaban{{ $value->id }}" value="baik">
                                <label class="form-check-label h5" for="jawaban">
                                    Baik
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban{{ $value->id }}" id="jawaban{{ $value->id }}" value="cukup">
                                <label class="form-check-label h5" for="jawaban">
                                    Cukup
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban{{ $value->id }}" id="jawaban{{ $value->id }}" value="kurang">
                                <label class="form-check-label h5" for="jawaban">
                                    Kurang
                                </label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-warning">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
</div>
@endsection
