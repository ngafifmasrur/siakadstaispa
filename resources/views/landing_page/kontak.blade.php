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
						<h5 class="mb-2 fw-semi-bold" align="left">Nama :</h5>
						<div class="input-group mb-3">
							<span class="input-group-addon bg-white"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" placeholder="Masukan Nama" name="email">
						</div>
						<h5 class="mb-2 fw-semi-bold" align="left">Email :</h5>
						<div class="input-group mb-4">
							<span class="input-group-addon bg-white"><i class="fa fa-unlock-alt"></i></span>
							<input type="password" class="form-control" placeholder="Email" name="password">
						</div>
                        <h5 class="mb-2 fw-semi-bold" align="left">Message :</h5>
                        <div class="col-lg-12">
                                                <div class="mb-3 app-label">
                                                    <textarea name="comments" id="comments" rows="5"
                                                        class="form-control" placeholder="Message"></textarea>
                                                </div>
                                            </div>
						<div class="col-lg-12">	
							<button type="submit" style="color:white; border-radius: 10px;display: block;width: 100%;border: none;background-color: #C2C851;padding: 14px 28px;font-size: 16px;cursor: pointer;text-align: center;">Kirim</button>
						</div>
					</div>
				</div>
			<div>
			<div class="row" style="background-color:#33B69E;padding:10px;border-radius: 10px;margin-left:10px;margin-right:10px;">
                <div class="col-lg-6">
                <button style="color:white; border-radius: 10px;display: block;width: 100%;border: none;background-color: #0C6656;padding: 14px 28px;font-size: 16px;cursor: pointer;text-align: center;">Call Us</button>
                </div>
                <div class="col-lg-6">
                <button style="color:#131515; border-radius: 10px;display: block;width: 100%;border: none;background-color: #FFFFFF;padding: 14px 28px;font-size: 16px;cursor: pointer;text-align: center;">staispayogyakarta@gmail.com</button>
                </div>
            </div>
		</div>
    </section>
@endsection