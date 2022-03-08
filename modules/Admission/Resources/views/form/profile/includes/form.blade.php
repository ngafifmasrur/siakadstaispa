<fieldset>
	<div class="row">
		<div class="col-md-7 offset-md-4">
			<h5 class="text-muted font-weight-normal mb-3">Informasi umum</h5>
		</div>
	</div>

	{{-- <div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right">Gelar depan</label>
		<div class="col-md-4">
			<input type="prefix" class="form-control @error('prefix') is-invalid @enderror" name="prefix" value="{{ old('prefix', $registrant->user->profile->prefix) }}" >
			@error('prefix')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
	</div> --}}

	<div class="form-group required row">
		<label class="col-md-4 col-form-label text-md-right">Nama lengkap</label>
		<div class="col-md-7">
			<input type="name" class="form-control @error('name') is-invalid @enderror " name="name" value="{{ old('name', $registrant->user->profile->name) }}" required autofocus>
			<small class="form-text text-muted">Nama lengkap (tidak boleh disingkat) diisi menggunakan huruf kapital sesuai Akta/KTP/KK atau identitas resmi lainnya.</small>
			@error('name')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
	</div>

	{{-- <div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right">Gelar belakang</label>
		<div class="col-md-4">
			<input type="suffix" class="form-control @error('suffix') is-invalid @enderror" name="suffix" value="{{ old('suffix', $registrant->user->profile->suffix) }}">
			@error('suffix')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
	</div> --}}

	<div class="form-group required row">
		<label class="col-md-4 col-form-label text-md-right">Tempat lahir</label>
		<div class="col-md-5">
			<input type="text" class="form-control @error('pob') is-invalid @enderror" name="pob" value="{{ old('pob', $registrant->user->profile->pob) }}" required>
			<small class="form-text text-muted">Nama lengkap diisi menggunakan huruf kapital sesuai Akta/KTP/KK atau identitas resmi lainnya.</small>
			@error('pob')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
	</div>

	<div class="form-group required row">
	    <label class="col-md-4 col-form-label text-md-right">Tanggal lahir</label>
	    <div class="col-md-5">
		    <div class="input-group date" id="dob" data-target-input="nearest">
		        <input type="text" class="form-control datetimepicker-input @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob', ($registrant->user->profile->dob ? $registrant->user->profile->dob->format('d-m-Y') : '')) }}" data-toggle="datetimepicker" data-target="#dob">
		        <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
		            <div class="input-group-text"><i class="mdi mdi-calendar"></i></div>
		        </div>
		    </div>
		    @error('dob')
		        <small class="text-danger"> {{ $message }} </small>
		    @enderror
		    <small class="form-text text-muted">Diisi dengan format hh-bb-tttt (ex: 23-02-{{ substr(config('admission.maximum-dob-year'), 0, 4) }}) dan sesuai dengan Kartu Keluarga atau akta kelahiran </small>
		</div>
	</div>

	<div class="form-group required row">
	    <label class="col-md-4 col-form-label text-md-right">Jenis kelamin</label>
	    <div class="col-md-4">
	        <select name="sex" class="form-control  @error('sex') is-invalid @enderror" required>
	            <option value="">-- Pilih --</option>
	            @foreach (config('web.references.sexes') as $k => $v)
	                <option value="{{ $k }}" @if((!is_null($registrant->user->profile->sex)) && (old('sex', $registrant->user->profile->sex) == $k)) selected @endif>{{ $v }}</option>
	            @endforeach
	        </select>
	        @error('sex')
	        	<span class="invalid-feedback"> {{ $message }} </span>
	        @enderror
	    </div>
	</div>

	<div class="form-group row">
	    <label class="col-md-4 col-form-label text-md-right">Golongan darah</label>
	    <div class="col-md-4">
	        <select name="blood" class="form-control @error('blood') is-invalid @enderror">
	            <option value="">-- Pilih --</option>
	            @foreach (config('web.references.bloods') as $k => $v)
	            <option value="{{ $k }}" @if((!is_null($registrant->user->profile->blood)) && (old('blood', $registrant->user->profile->blood) == $k)) selected @endif>{{ $v }}</option>
	            @endforeach
	        </select>
	        @error('blood')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
	    </div>
	</div>
</fieldset>
<hr>
<fieldset>
	<div class="row">
		<div class="col-md-7 offset-md-4">
			<h5 class="text-muted font-weight-normal mb-3">Upload foto calon mahasiswa</h5>
		</div>
	</div>
	<div class="form-group mb-0 required row">
		<label class="col-md-4 col-form-label text-md-right">Foto</label>
		<div class="col-md-8">
			<div class="row">
				<div class="col-sm-4 mb-3">
					<img id="preview_file" src="{{ $registrant->avatar ? Storage::url($registrant->avatar) : asset('/assets/img/img-blank-3-4.png') }}" class="rounded w-100 mb-2"/>
					<button type="button" class="btn btn-success btn-block btn-sm" data-toggle="modal" data-target="#modal-sample-avatar"> Lihat contoh </button>
				</div>
				<div class="col-sm-8">
		            @include('admission::form.includes.upload-guide')
		            <div class="custom-file">
		                <input type="file" class="custom-file-input form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*" @if(!$registrant->avatar) required @endif >
		                <label class="custom-file-label" for="avatar">Choose file</label>
		                @error('avatar')
		                	<span class="invalid-feedback"> <strong>{{ $message }}</strong> </span> 
		                @enderror
		            </div>
				</div>
			</div>
		</div>
	</div>
</fieldset>
<hr>
<fieldset>
	<div class="row">
	    <div class="col-md-7 offset-md-4">
	        <h5 class="text-muted font-weight-normal mb-3">Data kewarganegaraan</h5>
	    </div>
	</div>
	<div class="form-group required row">
	    <label class="col-md-4 col-form-label text-md-right">NIK</label>
	    <div class="col-md-7">
	        <input type="number" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik', $registrant->user->profile->nik) }}" required>
	        <small class="form-text text-muted">Nomor Induk Kependudukan, sesuai KTP/KK/Identitas resmi lainnya</small>
	        @error('nik')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
	    </div>
	</div>
	<div class="form-group required row">
	    <label class="col-md-4 col-form-label text-md-right">Nomor KK</label>
	    <div class="col-md-7">
	        <input type="number" class="form-control @error('nokk') is-invalid @enderror" name="nokk" value="{{ old('nokk', $registrant->user->profile->nokk) }}" required>
	        <small class="form-text text-muted">Nomor Induk Kependudukan, sesuai KTP/KK/Identitas resmi lainnya</small>
	        @error('nokk')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
	    </div>
	</div>
	<div class="form-group required row">
	    <label class="col-md-4 col-form-label text-md-right">Kewarganegaraan</label>
	    <div class="col-md-4">
	        <select name="country" class="form-control @error('country') is-invalid @enderror" required>
	            <option value="">-- Pilih --</option>
	            @foreach (config('web.references.countries') as $v)
	            <option value="{{ $v->id }}" @if((!is_null($registrant->user->profile->country_id)) && (old('country', $registrant->user->profile->country_id) == $v->id)) selected @endif>{{ $v->name }}</option>
	            @endforeach
	        </select>
	        @error('country')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
	    </div>
	</div>
</fieldset>
<hr>
<fieldset>
	<div class="row">
	    <div class="col-md-7 offset-md-4">
	        <h5 class="text-muted font-weight-normal mb-3">Data pendukung</h5>
	    </div>
	</div>
	<div class="form-group required row">
	    <label class="col-md-4 col-form-label text-md-right">NISN</label>
	    <div class="col-md-7">
	        <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ old('nisn', $registrant->user->profile->nisn) }}" required>
	        <small class="form-text text-muted">Nomor Induk Siswa Nasional, sesuai kartu NISN dari sekolah/madrasah asal</small>
	        @error('nisn')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
	    </div>
	</div>
	<div class="form-group required row">
		<label class="col-md-4 col-form-label text-md-right">Anak ke</label>
		<div class="col-md-3">
			<input type="number" class="form-control @error('child_order') is-invalid @enderror" name="child_order" value="{{ old('child_order', $registrant->user->profile->child_order) }}"  min="1" max="20" required>
			@error('child_order')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
	</div>
	<div class="form-group required row">
		<label class="col-md-4 col-form-label text-md-right">Dari jumlah saudara</label>
		<div class="col-md-3">
			<input type="number" class="form-control @error('siblings') is-invalid @enderror" name="siblings" value="{{ old('siblings', $registrant->user->profile->siblings) }}"  min="1" max="20" required>
			<small class="form-text text-muted">Termasuk calon mahasiswa (calon mahasiswa dihitung).</small>
			@error('siblings')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
	</div>
	<div class="form-group required row">
	    <label class="col-md-4 col-form-label text-md-right">Status anak</label>
	    <div class="col-md-4">
	        <select name="biological" class="form-control @error('biological') is-invalid @enderror" required>
	            @foreach (config('web.references.biologicals') as $k => $v)
	            <option value="{{ $k }}" @if(old('biological', $registrant->user->profile->biological) == $k) selected @endif>{{ $v }}</option>
	            @endforeach
	        </select>
	        @error('biological')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
	    </div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label text-md-right">Riwayat penyakit</label>
		<div class="col-md-7">
			<input type="text" class="form-control @error('illness') is-invalid @enderror" name="illness" value="{{ old('illness', $registrant->user->profile->illness) }}">
			@error('illness')
				<span class="invalid-feedback"> {{ $message }} </span>
			@enderror
		</div>
	</div>
</fieldset>
<hr>
<div class="form-group row mb-0">
	<div class="col-md-7 offset-md-4">
		<button class="btn btn-success" type="submit">Simpan</button>
		<a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
	</div>
</div>

@push('script')
	@include('admission::includes.modal-sample-avatar', ['id' => 'modal-sample-avatar'])
    <script type="text/javascript">
        $(function () {
            $('#dob').datetimepicker({
                maxDate: moment(),
                useCurrent: false,
                viewMode: 'years',
                format: 'DD-MM-YYYY'
            });
            $('[name="nik"], [name="nokk"]').mask('0'.repeat(16));
            $('[name="nisn"]').mask('0'.repeat(10));
            function readURL(input) {
                if (input.files && input.files[0]) {
                    $('[for="avatar"]').text(input.files[0].name)
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview_file').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('[name="avatar"]').change(function() {
                readURL(this);
            });
        })
    </script>
@endpush