<div class="row">
	<div class="col-sm-8">
		@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
		<div class="form-group mb-0 required">
			<label class="col-form-label">Tanggal Kedatangan ke pondok</label>
			<select class="form-control @error('tanggal_kedatangan') is-invalid @enderror" name="tanggal_kedatangan" id="tanggal_kedatangan">
				@foreach ($tanggal_kedatangan as $key => $item)
					<option value="{{ $item }}">{{ $item }}</option>
				@endforeach
			</select>
			
			@error('tanggal_kedatangan')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
	</div>
</div>
<div class="row mt-3">
    <div class="col-sm-8">
    	<div class="form-group mb-0">
        	<button class="btn btn-success" type="submit">Simpan</button>
        	<a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
    	</div>
    </div>
</div>