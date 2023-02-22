@extends('admission::layouts.default')

@section('navbar', view('admission::layouts.includes.navbar', ['primary' => true]))

@section('content')
    <div class="jumbotron rounded-0">
    	<div class="container py-5 my-5">
    		<div class="py-3">
    	    	<h1 class="mb-3 font-weight-normal">{{ config('admission.app.name') }}</h1>
    	    	<div class="mb-3">Kelengkapan berkas dan akurasi data mutlak diperlukan demi kelancaran proses pendaftaran. Apabila pendaftar tidak membawa berkas fisik dengan lengkap, maka dengan berat hati pendaftaran tidak bisa dilayani.</div>
    	    	@if($admissions->count())
    	    	    @if(count(config('admission.closed')) == 2)
    	    	        <div class="alert alert-danger">
    	    	            Mohon maaf, pendaftaran sementara kami tutup karena telah mencukupi kuota pendaftaran, terimakasih.
    	    	        </div>
    	    	    @endif
    		    	<div class="py-3">
    		    	    @if(count(config('admission.closed')) != 2)
    		    	        <a class="btn btn-success btn-pill btn-lg m-1" href="{{ auth()->check() ? route('admission.register') : route('account.register', ['next' => route('admission.register')]) }}">Daftar sekarang &raquo;</a>
    		    	    @endif
    		    		<a class="btn btn-outline-success btn-pill btn-lg m-1" href="{{ asset('Brosur_STAISPA_6_Januari.pdf') }}" target="_blank">Download Brosur &raquo;</a>
    		    	</div>
    		    	<p class="mb-0">Sudah pernah mendaftar? <a class="text-success" href="{{ route('admission.register') }}"><u>Klik disini</u></a></p>
    		    @else
    			    <div class="row justify-content-center">
    			    	<div class="col-lg-6">
    			    		<div class="alert alert-success btn-pill mb-0 text-dark">
    			    			Mohon maaf, pendaftaran untuk saat ini ditutup, silahkan ulangi beberapa waktu kedepan.
    			    		</div>
    			    	</div>
    			    </div>
    		    @endif
    		</div>
        </div>
    </div>

    <div class="container mb-5">
    	<div class="row justify-content-center">
    		<div class="col-11 col-md-9 col-lg-7">
    		    <img class="rounded shadow img-fluid" src="{{ asset('alur.jpg') }}" style="max-width: 100wh;margin-top: -25%;"/>
                <!--<div class="card border-0 shadow" style="height: 380px;margin-top: -25%;">-->
                <!--    <div class="card-body bg-dark border-0 text-center">-->
                <!--        <div style="margin-top: 150px;">-->
                            
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
    			{{-- <iframe class="shadow-lg rounded w-100" src="https://www.youtube.com/embed/CXDFWIwwxSw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="height: 380px;margin-top: -25%;"></iframe> --}}
    		</div>
    	</div>
    </div>
    
    <!--div class="container">
		<hr>
		<div class="row d-flex justify-content-center">
			<div class="col-md-12 my-5">
				<div class="text-center mb-4">
					<h4>Jumlah data pendaftar</h4>
					<p class="text-muted">Data mahasiswa per prodi dihitung dari seluruh mahasiswa aktif.</p>
				</div>
				<div class="table-responsive">
					<table class="table table-md table-hover">
						<thead>
							<tr>
								<th></th>
								<th colspan="2" class="text-center">IAT</th>
								<th colspan="2" class="text-center">IT</th>
								<th colspan="2" class="text-center">PBA</th>
								<th colspan="2" class="text-center">PGMI</th>
								<th colspan="2" class="text-center">KPI</th>
							</tr>
							<tr>
								<th></th>
								<th class="text-center">Pendaftar</th>
								<th class="text-center">Diterima</th>
								<th class="text-center">Pendaftar</th>
								<th class="text-center">Diterima</th>
								<th class="text-center">Pendaftar</th>
								<th class="text-center">Diterima</th>
								<th class="text-center">Pendaftar</th>
								<th class="text-center">Diterima</th>
								<th class="text-center">Pendaftar</th>
								<th class="text-center">Diterima</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><strong>2012</strong></td>
								<td class="text-center">23</td>
								<td class="text-center">21</td>
								<td class="text-center">13</td>
								<td class="text-center">11</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
							</tr>
							<tr>
								<td><strong>2013</strong></td>
								<td class="text-center">23</td>
								<td class="text-center">22</td>
								<td class="text-center">19</td>
								<td class="text-center">16</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
							</tr>
							<tr>
								<td><strong>2014</strong></td>
								<td class="text-center">36</td>
								<td class="text-center">30</td>
								<td class="text-center">29</td>
								<td class="text-center">28</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
							</tr>
							<tr>
								<td><strong>2015</strong></td>
								<td class="text-center">55</td>
								<td class="text-center">52</td>
								<td class="text-center">28</td>
								<td class="text-center">23</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
								<td class="text-center">0</td>
							</tr>
							<tr>
								<td><strong>2016</strong></td>
								<td class="text-center">48</td>
								<td class="text-center">43</td>
								<td class="text-center">25</td>
								<td class="text-center">20</td>
								<td class="text-center">36</td>
								<td class="text-center">32</td>
								<td class="text-center">55</td>
								<td class="text-center">54</td>
								<td class="text-center">50</td>
								<td class="text-center">25</td>
							</tr>
							<tr>
								<td><strong>2017</strong></td>
								<td class="text-center">40</td>
								<td class="text-center">40</td>
								<td class="text-center">22</td>
								<td class="text-center">22</td>
								<td class="text-center">28</td>
								<td class="text-center">28</td>
								<td class="text-center">54</td>
								<td class="text-center">51</td>
								<td class="text-center">52</td>
								<td class="text-center">26</td>
							</tr>
							<tr>
								<td><strong>2018</strong></td>
								<td class="text-center">57</td>
								<td class="text-center">57</td>
								<td class="text-center">27</td>
								<td class="text-center">27</td>
								<td class="text-center">26</td>
								<td class="text-center">26</td>
								<td class="text-center">55</td>
								<td class="text-center">55</td>
								<td class="text-center">52</td>
								<td class="text-center">31</td>
							</tr>
							<tr>
								<td><strong>2019</strong></td>
								<td class="text-center">76</td>
								<td class="text-center">75</td>
								<td class="text-center">40</td>
								<td class="text-center">36</td>
								<td class="text-center">54</td>
								<td class="text-center">48</td>
								<td class="text-center">75</td>
								<td class="text-center">74</td>
								<td class="text-center">77</td>
								<td class="text-center">70</td>
							</tr>
							<tr>
								<td><strong>2020</strong></td>
								<td class="text-center">44</td>
								<td class="text-center">37</td>
								<td class="text-center">27</td>
								<td class="text-center">22</td>
								<td class="text-center">43</td>
								<td class="text-center">38</td>
								<td class="text-center">39</td>
								<td class="text-center">34</td>
								<td class="text-center">33</td>
								<td class="text-center">29</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div-->

    {{-- @if($admissions->first())
        <div class="container my-5 py-md-5">
            <div class="row">
                <div class="col-lg-6 align-self-center text-center d-none d-lg-block">
                    <img src="{{ asset('assets/img/undraw/undraw_forming_ideas_0pav.svg') }}" style="height: 320px; pointer-events: none;">
                </div>
                <div class="col-lg-6 align-self-center">
                    <H4 class="mb-4"><strong>Persyaratan umum</strong></H4>
                    <ul class="pl-4 text-muted">
                        @foreach($admissions->first()->generalRequirements as $req)
                            <li class="mb-1">{{ $req->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="container my-5 py-md-5">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <H4 class="mb-4"><strong>Persyaratan khusus</strong></H4>
                    <ul class="pl-4 text-muted">
                        @foreach($admissions->first()->specialRequirements as $req)
                            <li class="mb-1">{{ $req->name }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-6 align-self-center text-center d-none d-lg-block">
                    <img src="{{ asset('assets/img/undraw/undraw_online_discussion_5wgl.svg') }}" style="height: 320px; pointer-events: none;">
                </div>
            </div>
        </div>

        <div class="container my-5 py-md-5">
            <div class="row">
                <div class="col-lg-6 align-self-center text-center d-none d-lg-block">
                    <img src="{{ asset('assets/img/undraw/undraw_upload_87y9.svg') }}" style="height: 320px; pointer-events: none;">
                </div>
                <div class="col-lg-6 align-self-center">
                    <H4 class="mb-4"><strong>Berkas yang diupload</strong></H4>
                    <ul class="pl-4 text-muted">
                        @foreach($admissions->first()->files as $file)
                            <li class="mb-1">{{ $file->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif --}}
@endsection

@push('script')
    <style>
        .navbar.scrolled {
            transition: background-color 200ms linear;
        }
    </style>
    <script>
        var __nav = $(".navbar");
        $(() => {
            if($(window).scrollTop() >= 20) {
                __nav.addClass("bg-light");
                __nav.removeClass("bg-transparent");
            }
            $(window).scroll(function() {    
                var scroll = $(window).scrollTop();
                if (scroll >= 20) {
                    __nav.addClass("bg-light scrolled");
                    __nav.removeClass("bg-transparent");
                } else {
                    __nav.addClass("bg-transparent scrolled");
                    __nav.removeClass("bg-light");
                }
            });
            $('.navbar-toggler[data-toggle="collapse"]').click(() => {
                if(!$('.navbar-collapse').hasClass('show')) {
                    __nav.addClass("bg-light scrolled");
                    __nav.removeClass("bg-transparent");
                } else {
                    __nav.addClass("bg-transparent scrolled");
                    __nav.removeClass("bg-light");
                }
            })
        })
    </script>
@endpush