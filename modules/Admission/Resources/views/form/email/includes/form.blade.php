<div class="row">
	<div class="col-sm-8">
		<div class="form-group mb-0 required">
			<label class="col-form-label">Alamat e-mail</label>
			<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $registrant->user->email->address) }}" required autofocus>
			@error('email')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
		{{-- @if ($registrant->user->email->address) 
			<div class="mt-2 mb-1">Status verifikasi</div>
			@if ($registrant->user->email->verified_at) 
				<div class="text-success"><i class="icon-check"></i> Terverifikasi</div>
			@else
				<div class="text-danger"><i class="icon-close"></i> Belum terverifikasi</div>
				<a href="{{ route('account.user.email.reverify', ['uid' => encrypt($registrant->user->email->id), 'next' => url()->full()]) }}">Kirim tautan verifikasi sekarang!</a>
			@endif
		@endif --}}
	</div>
</div>
{{-- @if ($registrant->user->email->verified_at)
	<hr>
	<p class="mb-0">
		<strong>Peringatan!</strong> <br>
		Jika Anda mengubah alamat e-mail Anda, kami akan melakukan verifikasi ulang terhadap e-mail Anda
	</p>
	@endif --}}
<div class="row mt-3">
    <div class="col-sm-8">
    	<div class="form-group mb-0">
        	<button class="btn btn-success" type="submit">Simpan</button>
        	<a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
    	</div>
    </div>
</div>