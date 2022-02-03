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
            <label for="kurikulum" class="font-weight-bold">Kurikulum</label>
            {!! Form::select('kurikulum', $kurikulum, null, ['class' => 'form-control', 'id' => 'kurikulum']) !!}
        </div>
        <div class="form-group col-lg-3 mt-auto">
            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
            data-placement="top" title="Silahkan Pilih Kurikulum dan Program Studi terlebih dahulu" id="kurikulum_prodi">
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

            $(document).on('change','#prodi, #kurikulum',function(){
                if($('#prodi').val() && $('#kurikulum').val()) {
                    var kurikulum =  $('#kurikulum').val();
                    var prodi =  $('#prodi').val();

                    $('.kurikulum_prodi').attr('disabled', false);
                    $('#kurikulum_prodi').removeAttr("data-original-title");
                    $('.kurikulum_prodi').css( 'pointer-events', 'auto' );
                    
                    table = "{{ url('/admin/kurikulum_prodi/tabel') }}"+"/"+kurikulum+"/"+prodi;
   
                    $('.kurikulum_prodi').attr( 'onclick', "location.href="+"'"+table+"'" );


                } else {
                    $('.kurikulum_prodi').attr('disabled', true);
                    $('#kurikulum_prodi').attr("data-original-title", "Silahkan Pilih Kurikulum dan Program Studi terlebih dahulu");
                    $('.kurikulum_prodi').css( 'pointer-events', 'none' );
                }
            });
        });
    </script>
@endpush