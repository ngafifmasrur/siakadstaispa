@extends('landing_page.layouts.app')
@section('title', 'Landing Page - Berita')

@section('content')
<section class="section kontak-bg">
		<div class="container" style="padding-top:50px;">
			<div class="title-heading mb-5">
                        <h3 class="text-white mb-1 fw-semi-bold ">Kontak</h3>
                        <img src="{{ asset('landing_page/images/line.png') }}" alt="" width="120" class="  d-block">
             </div>
		</div>
		<div align="center">
			<div class="col-lg-6" style="padding-top:50px;">
				<div class="card" >
					<div class="card-body p-5">
						<h5 class="mb-2 fw-semi-bold" align="left">Alamat :</h5>
						<div class="row">
							<div class="col-lg-6" align="left">
								<iframe width="250" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.87614446338!2d110.4020837143332!3d-7.696438794451897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5ebf33517f0b%3A0xa858027f9c52215!2sSTAI%20Sunan%20Pandanaran!5e0!3m2!1sid!2sid!4v1644963011474!5m2!1sid!2sid"></iframe>
							</div>
							<div class="col-lg-6" >
								<p style="text-align: justify;">Jl. Kaliurang Km. 12,5, Candi, Sardonoharjo, Ngaglik , Kab. Sleman - Prov. D.I. Yogyakarta - Indonesia - 55581</p>
							</div>
						</div>
						
					</div>
				</div>
			<div>
			<div class="row" style="background-color:#33B69E;padding:10px;border-radius: 10px;margin-left:10px;margin-right:10px;">
                <div class="col-lg-6">
                <button style="color:white; border-radius: 10px;display: block;width: 100%;border: none;background-color: #0C6656;padding: 14px 28px;font-size: 16px;cursor: pointer;text-align: center;">Call Us : <br>(0274) 7496585, 8808</button>
                </div>
                <div class="col-lg-6 mt-2">
                <button style="color:#131515; border-radius: 10px;display: block;width: 100%;border: none;background-color: #FFFFFF;padding: 14px 28px;font-size: 16px;cursor: pointer;text-align: center;">staispayogyakarta@gmail.com</button>
                </div>
            </div>
		</div>
    </section>
@endsection