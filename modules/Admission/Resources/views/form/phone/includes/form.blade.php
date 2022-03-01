<div class="row">
	<div class="col-sm-8">
		<div class="form-group required">
			<label class="col-form-label">Nomor HP</label>
			<input type="text" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" value="{{ old('number', $registrant->user->phone->number) }}" required autofocus>
			<small class="form-text text-muted">Ditulis menggunakan kode negara, misal 085123xxxxx menjadi 6285123xxxxx (tanpa tanda plus)</small>
			@if ($errors->has('number')) 
				<span class="invalid-feedback"> {{ $errors->first('number') }} </span>
			@endif
		</div>
		<div class="form-group mb-0">
		    <div class="custom-control custom-checkbox">
		        <input class="custom-control-input" type="checkbox" id="whatsapp" value="1" name="whatsapp" @if($registrant->user->phone->whatsapp) checked @endif>
		        <label class="custom-control-label" for="whatsapp">Nomor ini <strong><span id="whatsapp-text">@if(!$registrant->user->phone->whatsapp) tidak @endif</span> terdaftar</strong> di whatsapp</label>
		    </div>
		</div>
	</div>
</div>
<hr>
<div class="row">
    <div class="col-sm-8">
    	<div class="form-group mb-0">
        	<button class="btn btn-success" type="submit">Simpan</button>
        	<a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
    	</div>
    </div>
</div>	

@push('script')
	<script>
		$('#whatsapp').on('click', (e) => {
		    $('#whatsapp-text').text($(e.target).is(':checked') ? '' : 'tidak')
		});
	</script>
@endpush