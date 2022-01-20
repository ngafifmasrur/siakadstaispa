@extends('layouts.app')
@section('title', 'Kurikulum Prodi')

@section('content')
<x-header>
    Kurikulum Prodi
</x-header>

<x-card>
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="prodi" class="font-weight-bold">Program Studi</label>
            {!! Form::select('prodi', $prodi, null, ['class' => 'form-control', 'id' => 'prodi', 'data-targt' => '#id_matkul']) !!}
        </div>
        <div class="form-group col-lg-3">
            <label for="tahun_ajaran" class="font-weight-bold">Tahun Pelajaran</label>
            {!! Form::select('tahun_ajaran', $tahun_ajaran, null, ['class' => 'form-control', 'id' => 'tahun_ajaran']) !!}
        </div>
        <div class="form-group col-lg-3 mt-auto">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
            data-placement="top" title="Silahkan Pilih Tahun Ajaran dan Program Studi terlebih dahulu" id="kurikulum_prodi">
              <button type="button" style="pointer-events: none;" class="btn btn-app btn-sm btn-primary kurikulum_prodi">Tabel Kurikulum Prodi</button>
            </span>
        </div>
    </div>
</x-card>
@endsection

@push('js')
    <script>
        $( document ).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $(document).on('change','#prodi, #tahun_ajaran',function(){
                if($('#prodi').val() && $('#tahun_ajaran').val()) {
                    var tahun_ajaran =  $('#tahun_ajaran').val();
                    var prodi =  $('#prodi').val();

                    $('.kurikulum_prodi').attr('disabled', false);
                    $('#kurikulum_prodi').removeAttr("data-original-title");
                    $('.kurikulum_prodi').css( 'pointer-events', 'auto' );
                    
                    table = "{{ url('/admin/kurikulum_prodi/create') }}"+"/"+tahun_ajaran+"/"+prodi;
   
                    $('.kurikulum_prodi').attr( 'onclick', "location.href="+"'"+table+"'" );


                } else {
                    $('.kurikulum_prodi').attr('disabled', true);
                    $('#kurikulum_prodi').attr("data-original-title", "Silahkan Pilih Tahun Ajaran dan Program Studi terlebih dahulu");
                    $('.kurikulum_prodi').css( 'pointer-events', 'none' );
                }
            });
        });
    </script>
@endpush