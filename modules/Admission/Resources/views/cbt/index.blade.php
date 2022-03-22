@extends('admission::layouts.default')

@section('subtitle', 'CBT - ')

@push('style')
    <style>
        @font-face {
            font-family: "majallab";
            src: url('{{ asset('/majallab.ttf') }}') format("truetype");
        }

        .majallab {
            font-family: "majallab";
            float: right;
            text-align: right;
        }

        .addButton {
            width: 50px!important;
        }

        .listnumber{
            background:green;
            margin: 5px;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
        }
        .section {
            margin-top: 40px;
        }
        .card {
            margin-bottom: 20px;
        }
        .btn-size{
            width: 40px;
            border: none;
        }

        .box {
            width: 40px;
            height: 40px;
        }

        p {
            display: inline !important;
        }
        .font-size{
            border: 1px solid #333;
            border-radius: 4px;
            margin-right: 10px;
        }
        .font-size:hover, .font-size.active{
            background: blue;
            color: #fff;
            cursor: pointer;
        }
        #fz_mini{
            padding: 3px 5px;
            font-size: 14px;
        }
        #fz_normal{
            padding: 3px 5px;
            font-size: 16px;
        }
        #fz_large{
            padding: 3px 5px;
            font-size: 18px;
        }
    </style>
@endpush

@section('content')
	<div class="container">
        <form action="{{ route('admission.cbt.submit_form') }}" id="selesai-ujinya" method="post">
            @csrf
            <div class="row">
                <input type="hidden" name="cbt_id" value="{{ $cbt->id }}">
                <input type="hidden" name="cbt_peserta_id" value="{{ $cbt_peserta->id }}">
                <input type="hidden" name="waktu" id="waktujalan">

                <div class="col-md-8">
                    @foreach($dt_soal as $key => $row)
                    <div id="soal_{{$row->id_soal}}" class="soal" style="display: {{$key == 0 ? 'block' : 'none'}}">
                    <br>
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Soal Nomor {{$key+1}}</h5>
                            @if ($cbt_peserta->admission_cbt->mapel == 'Bahasa Arab')
                                <div class="soal_ujian majallab" dir="auto" style="display: grid;">
                                    {!! $row->soal !!}
                                </div>
                            @else
                                <div class="soal_ujian" style="display: grid;">
                                    {!! $row->soal !!}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Jawaban </h5>
                        <div id="jawaban" class="jawaban">
                            <input type="hidden" value="{{$row->id_soal}}" name="soal_id[]">

                            @if ($cbt_peserta->admission_cbt->mapel == 'Bahasa Arab')
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_a" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="A" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'A') ? 'checked' : ''}}>
                                    <label class="custom-control-label majallab radio-inline" dir="auto"  for="customRadio{{$row->id_soal}}_a"> {!! 'أ'.'.  '.$row->jawaban_a !!} </label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_b" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="B" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'B') ? 'checked' : ''}}>
                                    <label class="custom-control-label majallab radio-inline" dir="auto"  for="customRadio{{$row->id_soal}}_b"> {!! 'ب'.'.  '.$row->jawaban_b !!} </label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_c" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="C" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'C') ? 'checked' : ''}}>
                                    <label class="custom-control-label majallab radio-inline" dir="auto"  for="customRadio{{$row->id_soal}}_c"> {!! 'ج'.'.  '.$row->jawaban_c !!} </label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_d" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="D" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'D') ? 'checked' : ''}}>
                                    <label class="custom-control-label majallab radio-inline" dir="auto"  for="customRadio{{$row->id_soal}}_d"> {!! 'د'.'.  '.$row->jawaban_d !!} </label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_e" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="E" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'E') ? 'checked' : ''}}>
                                    <label class="custom-control-label majallab radio-inline" dir="auto" for="customRadio{{$row->id_soal}}_e"> {!! 'ه'.'.  '.$row->jawaban_e !!} </label>
                                </div>
                            @else
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_a" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="A" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'A') ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadio{{$row->id_soal}}_a"> {!! 'A'.'.  '.$row->jawaban_a !!} </label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_b" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="B" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'B') ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadio{{$row->id_soal}}_b"> {!! 'B'.'.  '.$row->jawaban_b !!} </label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_c" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="C" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'C') ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadio{{$row->id_soal}}_c"> {!! 'C'.'.  '.$row->jawaban_c !!} </label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio{{$row->id_soal}}_d" name="jawaban_{{$row->id_soal}}" class="custom-control-input" id="jawaban-id" value="D" data-id_soal="{{ $row->id_soal }}" data-soal="{{$row->id}}" data-jawaban="{{ $row->id_jawaban_peserta }}" {{($row->jawaban_peserta == 'D') ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="customRadio{{$row->id_soal}}_d"> {!! 'D'.'.  '.$row->jawaban_d !!} </label>
                                </div>
                            @endif


                        </div>
                        </div>
                    </div>
            
                    <div class="card">
                        <div class="card-body">
                        <div class="col-xl-12 text-center">
            
                            @if($key != count($dt_soal)-1)
                            <div id="button-next">
                            <a  href="javascript:void(0);" class="btn btn-success" style="float: right;" id="next{{$dt_soal[$key]->id_soal}}" onclick="selanjutnya('{{$dt_soal[$key+1]->id_soal}}')" >Soal Selanjutnya</a>
                            </div>
                            @elseif($key == count($dt_soal)-1)
                            <div id="button-next">
                            <button type="button" id="ujian-selesai" data-ujian_peserta_id="{{$cbt_peserta->id}}" class="btn btn-primary" style="float: right;">Selesai Ujian</button>
                            </div>
                            @endif
            
            
                            <input type="hidden" id="id_soal_nya" name="">
                            <input type="hidden" id="nomornya" name="">
                            <a href="javascript:void(0);" class="btn btn-warning button-ragu" id="btn_ragu{{$row->id_soal}}" onclick="ragu_ragu('{{$row->id_soal}}')">Ragu - Ragu</a>
            
                            <input type="hidden" id="ragu_ragu" name="">
                            @if($key != 0)
                            <a  href="javascript:void(0);"  class="btn btn-secondary" id="button-sebelum{{$dt_soal[$key]->id_soal}}" style="float: left;" onclick="sebelum('{{$dt_soal[$key-1]->id_soal}}')">Soal Sebelumnya </a>
                            @endif
            
                            <input type="hidden" id="id_soal_nya_sebelum" name="">
                            <input type="hidden" id="nomornya_sebelum" name="">
                        </div>
                        </div>
                    </div>
                    </div>
                    @endforeach

                </div>
                <div class="col-md-4">
                    <span class="p-2 bg-primary rounded">Sisa Waktu : <span id="waktu">00:00:00</span></span>
                    <span class="btn btn-info text-white" onclick="informasi()">Informasi</span>

                    <div class="card p-3 mt-3 listpilihan" style="height: 600px; overflow-y: scroll;">
                        <div class="card-title">List Nomor Soal</div>
                        <div class="row container">
                        @php $no = 1 @endphp
                        @foreach($dt_soal as $row)
                        <div class="col-2 m-2 click">
                            <a id="soal_id{{$row->id_soal}}" data-soal_id="" data-answered="{{ $row->status_jawaban != null ? 1 : 0 }}" class="btn btn-{{ $row->status_jawaban != null ? 'success' : 'secondary' }}  btn-size addButton" onclick="return getId({!!$row->id_soal!!}, {!!$no!!})"> {{$no}}
                            </a>
                            <input id="soal-id-{{$no}}" value="{{ $row->id_soal }}" type="hidden" >
                        </div>
                
                        @php $no++ @endphp
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
	</div>

 <!-- sisa waktu -->
  <div class="modal fade" id="confirm-sisa-waktu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="font-size: 18px;font-weight: bold;">
          Apakah Anda Yakin Mengakhiri Ujian Ini?
        </div>
        <div class="modal-body text-center">
          <p style="font-size: 18px">Anda masih meliki sisa waktu: </p>
          <h2 id="sisa-waktu-modal"></h2>
          <p id="jumlah-soal"></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button class="btn btn-warning" data-dismiss="modal" id="yakin-confirm">Yakin</button>
        </div>
      </div>
    </div>
  </div>

  <!-- koneksi -->
  <div class="modal fade" id="koneksi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="font-size: 18px;font-weight: bold;">
          Ooppss. Koneksi Internet Terputus
        </div>
        <div class="modal-body text-center">
          <h2 style="font-size: 18px">Koneksi Internet Terputus</h2>

        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <!-- Confirm selesai -->
  <div class="modal fade" id="confirm-selesai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="font-size: 18px;font-weight: bold;">
          Apakah Anda Yakin Menyelesaikan Ujian Ini?
        </div>
        <div class="modal-body" style="font-size: 15px;">
          Jika Ya, klik tombol "Selesai", Jika Tidak, klik tombol "Cancel". <br>
          <span style="color: #c0392b;font-size: 13px;">(Ujian Tidak bisa dibuka kembali setelah klik tombol "Selesai")</span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button class="btn btn-warning btn-ok">Selesai</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Informasi -->
  <div class="modal fade" id="Informasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          Informasi Ujian
        </div>
        <div class="modal-body">
          <h5>Keterangan </h5>
          <span class="btn btn-success"></span> Sudah Dijawab
          <br/>
          <span class="btn btn-warning"></span> Ragu Ragu
          <br/>
          <span class="btn btn-primary" style="background-color: blue;"></span> Sedang di nomor
          <br/>
          <br>
          <h5>Tombol Shortcut</h5>
          <span>Tekan <b>A</b> untuk memilih jawaban A</span>
          <br>
          <span>Tekan <b>B</b> untuk memilih jawaban B</span>
          <br>
          <span>Tekan <b>C</b> untuk memilih jawaban C</span>
          <br>
          <span>Tekan <b>D</b> untuk memilih jawaban D</span>
          <br>
          <span>Tekan <b>R</b> jika anda masih ragu-ragu</span>
          <br>
          <span>Tekan <b>I</b> untuk melihat informasi</span>
          <br>
          <span>Tekan <b>1</b> untuk mengubah ukuran font (kecil)</span>
          <br>
          <span>Tekan <b>2</b> untuk mengubah ukuran font (sedang)</span>
          <br>
          <span>Tekan <b>3</b> untuk mengubah ukuran font (besar)</span>
          <br>
          <span>Tekan <b>tombol arah kanan</b> untuk menuju soal berikutnya</span>
          <br>
          <span>Tekan <b>tombol arah kiri</b> untuk menuju soal sebelumnya</span>
          <br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Dihentikan -->
  <div class="modal fade" id="dihentikan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          Ujian Dihentikan
        </div>
        <div class="modal-body">
          <h2 class="text-center">Ujian anda telah dihentikan oleh Panitia</h2>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn-dihentikan" class="btn btn-default">Ok</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script type="text/javascript">
    var time_stop = false;
    var no_sekarang = {{$dt_soal[0]->id_soal}};

    $(document).ready(function(){
        var id_t_ujian = "{{ $cbt_peserta->id }}";
        set_waktu(id_t_ujian);

        $(document).on('click', '.custom-control-input', function(){
            var soal_id = $(this).data('soal');
            var id_soal = $(this).data('id_soal');
            var id_jawaban_peserta = $(this).data('jawaban');
            var jawaban_peserta = $(this).val();
            var url = "{{ route('admission.cbt.kirimjawaban') }}";
            var csrf = $('meta[name="csrf_token"]').attr('content');

            $.ajax({
            type: "GET",
            data: {'soal_id' : soal_id, 'id_jawaban_peserta' : id_jawaban_peserta, 'jawaban_peserta' : jawaban_peserta ,'_token':csrf},
            url: url,
                success: function(data){
                    $('#soal_id'+id_soal).removeClass();
                    $('#soal_id'+id_soal).removeAttr("style");
                    $('#soal_id'+id_soal).attr("data-answered","1");
                    $('#soal_id'+id_soal).addClass('btn btn-success btn-size addButton');
                }
            });
        });
    });

    var waktu = "{{ $cbt_peserta->sisa_waktu }}";

    function secondstotime(secs)
    {
        var t = new Date(1970,0,1);
        t.setSeconds(secs);
        var s = t.toTimeString().substr(0,8);
        if(secs > 86399)
            s = Math.floor((t - Date.parse("1/1/70")) / 3600000) + s.substr(2);
        return s;
    }

    var x = setInterval(function() {
        if(!time_stop){

            // Find the distance between now and the count down date
            var distance = --waktu;

            // Display the result in the element with id="waktu"
            document.getElementById("waktu").innerHTML = secondstotime(waktu);
            document.getElementById("waktujalan").value = waktu;

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("waktu").innerHTML = "00:00:00";
                $('#selesai-ujinya').submit();
            }
        }
    }, 1000);

    var range = function(start, end, step) {
    var range = [];
    var typeofStart = typeof start;
    var typeofEnd = typeof end;

    if (step === 0) {
        throw TypeError("Step cannot be zero.");
    }

    if (typeofStart == "undefined" || typeofEnd == "undefined") {
        throw TypeError("Must pass start and end arguments.");
    } else if (typeofStart != typeofEnd) {
        throw TypeError("Start and end arguments must be of same type.");
    }

    typeof step == "undefined" && (step = 1);

    if (end < start) {
        step = -step;
    }

    if (typeofStart == "number") {
        while (step > 0 ? end >= start : end <= start) {
        range.push(start);
        start += step;
        }

        } else if (typeofStart == "string") {

            if (start.length != 1 || end.length != 1) {
            throw TypeError("Only strings with one character are supported.");
            }

            start = start.charCodeAt(0);
            end = end.charCodeAt(0);

            while (step > 0 ? end >= start : end <= start) {
            range.push(String.fromCharCode(start));
            start += step;
            }

        } else {
            throw TypeError("Only string and number types are supported");
        }
    return range;
    }

    function selanjutnya(id_soal){
        diklik(id_soal);
        $('.soal').slideUp('fast');
        $('#soal_'+id_soal).slideDown('fast');
        no_sekarang = id_soal;
        // console.log("=>"+no_sekarang);
    }

    function sebelum(id_soal){
        diklik(id_soal);
        $('.soal').slideUp('fast');
        $('#soal_'+id_soal).slideDown('fast');
        no_sekarang = id_soal;
        // console.log('=<'+no_sekarang);
    }

    function ragu_ragu(id_soal){
        if($('#soal_id'+id_soal).hasClass('btn-warning')){
            $('#btn_ragu'+id_soal).html('Ragu - Ragu');
            $('#soal_id'+id_soal).removeClass();
            $('#soal_id'+id_soal).removeAttr("style");

            if($('#soal_id'+id_soal).attr('data-answered') == 1){
            $('#soal_id'+id_soal).addClass('btn btn-success btn-size addButton');
            }else{
            $('#soal_id'+id_soal).addClass('btn btn-secondary btn-size addButton');
            }


        }else{
            $('#btn_ragu'+id_soal).html('Hilangkan Ragu - Ragu');
            $('#soal_id'+id_soal).removeClass();
            $('#soal_id'+id_soal).removeAttr("style");
            $('#soal_id'+id_soal).addClass('btn btn-warning btn-size addButton');
        }
    }

    function diklik(id_soal){
        $('.addButton').removeAttr("style");
        $('#soal_id'+id_soal).css("background-color", "#2980b9");
        $('#soal_id'+id_soal).css("color", "white");
        var fz_id = $(".font-size.active").attr('id');
        set_font_size(fz_id);
        no_sekarang = id_soal;
    }

    function getId(id_soal, nomor){
        diklik(id_soal);
        $('.soal').slideUp('fast');
        $('#soal_'+id_soal).slideDown('fast');
    }

    function set_waktu(id) {
        setInterval(function(){
            var waktunow = $('#waktujalan').val();
            var url_waktu = "{{ route('admission.cbt.set_waktu') }}";
            var csrf = $('meta[name="csrf_token"]').attr('content');
            $.ajax({
            url: url_waktu,
            type: "GET",
            data: {'id': id,'waktu' : waktunow, '_token' : csrf},
            success: function(response){
            console.log(response);
            }
        });
        }, 150000);
    }

    $(document).on('click', '#ujian-selesai', function(){
        var id = $(this).data('ujian_peserta_id');
        var url_soal_terjawab = "{{ route('admission.cbt.soal_terjawab') }}";
        var csrf = $('meta[name="csrf_token"]').attr('content');
        $.ajax({
            url: url_soal_terjawab,
            type: "GET",
            data: {'id': id, '_token' : csrf},
            success: function(response){
                let jml_soal_sudah_dijawab = response.jml_soal_sudah_dijawab;
                let jml_soal_seluruhnya = response.jml_soal_seluruhnya;
                $("#jumlah-soal").html(`Anda sudah menjawab ${jml_soal_sudah_dijawab} dari total ${jml_soal_seluruhnya} soal`);
                $("#sisa-waktu-modal").html($("#waktu").html());
                $("#confirm-sisa-waktu").modal('show');
            },
        });
    });

    $(document).on('click', '#yakin-confirm', function(){
        $("#confirm-selesai").modal('show');
    });


    $(document).on('click', '.btn-ok', function(){
        $('#selesai-ujinya').submit();
    });

    $(".font-size").on('click', function(){
        var fz_id = $(this).attr('id');
        set_font_size(fz_id);
        $(".font-size").removeClass('active');
        $(this).addClass('active');
    })

    function set_font_size(fz_id){
        if(fz_id == 'fz_normal'){
            $(".soal_ujian").css('font-size', '16px');
            $(".jawaban").css('font-size', '16px');
        }else if(fz_id == 'fz_large'){
            $(".soal_ujian").css('font-size', '18px');
            $(".jawaban").css('font-size', '18px');
        }else{
            $(".soal_ujian").css('font-size', '14px');
            $(".jawaban").css('font-size', '14px');
        }
    }

    function informasi(){
        $('#Informasi').modal('show');
    }

    document.addEventListener('keyup', function (event) {
        if (event.defaultPrevented) {
            return;
        }

        var key = event.key || event.keyCode;
        console.log(no_sekarang);

        /*
        if (key === 'ArrowRight') {
            $('#next'+no_sekarang).click();
        }
        else if (key === 'ArrowLeft') {
            $('#button-sebelum'+no_sekarang).click();
        }
        */
        if (key === 'R' || key === 'r') {
            ragu_ragu(no_sekarang);
        }
        else if (key === 'I' || key === 'i') {
            informasi();
        }

        //
        if(key === "A" || key === "a"){
        $('#customRadio'+no_sekarang+'_0').click();
        }else if(key === "B" || key === "b"){
        $('#customRadio'+no_sekarang+'_1').click();
        }else if(key === "C" || key === "c"){
        $('#customRadio'+no_sekarang+'_2').click();
        }else if(key === "D" || key === "d"){
        $('#customRadio'+no_sekarang+'_3').click();
        }else if(key === "E" || key === "e"){
        $('#customRadio'+no_sekarang+'_4').click();
        }


        if(key === "1"){
        $('#fz_mini').click();
        }else if(key === "2"){
        $('#fz_normal').click();
        }else if(key === "3"){
        $('#fz_large').click();
        }
    });
</script>
@endpush