@php

$user = $registrant->user;

@endphp

<fieldset>
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <h5 class="text-muted font-weight-normal mb-3">Data utama {{ $trans }}</h5>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">NIK {{ $trans }}</label>
        <div class="col-md-8">
            <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik', $parent->nik) }}" required autofocus>
            <small class="form-text text-muted">Nomor Induk Kependudukan {{ $trans }}, bisa dilihat di Kartu Keluarga</small>
            @if ($errors->has('nik')) <span class="invalid-feedback"> {{ $errors->first('nik') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Nama lengkap {{ $trans }}</label>
        <div class="col-md-8">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $parent->name) }}" required>
            <small class="form-text text-muted">Diisi dengan menggunakan huruf kapital dan sesuai KTP/KK/Identitas lainnya, tidak menggunakan gelar</small>
            @if ($errors->has('name')) <span class="invalid-feedback"> {{ $errors->first('name') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Tempat lahir</label>
        <div class="col-md-5">
            <input type="text" class="form-control @error('pob') is-invalid @enderror" name="pob" value="{{ old('pob', $parent->pob) }}" required>
            <small class="form-text text-muted">Diisi dengan menggunakan huruf kapital dan sesuai dengan Kartu Keluarga </small>
            @if ($errors->has('pob')) <span class="invalid-feedback"> {{ $errors->first('pob') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Tanggal lahir</label>
        <div class="col-md-5">
            <div class="input-group date" id="dob" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob', ($parent->dob ? $parent->dob->format('d-m-Y') : '')) }}" data-toggle="datetimepicker" data-target="#dob" autocomplete="off">
                <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="mdi mdi-calendar"></i></div>
                </div>
            </div>
            @error('dob')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
            <small class="form-text text-muted">Diisi dengan format hh-bb-tttt (ex: 23-02-{{ date('Y', strtotime(config('admisison.maximum-dob-year'))) }}) dan sesuai dengan Kartu Keluarga atau akta kelahiran </small>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Status {{ $trans }}</label>
        <div class="col-md-5">
            <select name="biological" class="form-control @error('biological') is-invalid @enderror" required>
                @foreach (config('web.references.biologicals') as $i => $v)
                    <option value="{{ $i }}" @if(old('biological', $parent->biological) == $i) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
            @if ($errors->has('biological')) <span class="invalid-feedback"> {{ $errors->first('biological') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Keadaan {{ $trans }}</label>
        <div class="col-md-5">
            <select name="is_dead" class="form-control @error('is_dead') is-invalid @enderror" required>
                @foreach (config('web.references.is_deads') as $i => $v)
                    <option value="{{ $i }}" @if(old('is_dead', $parent->is_dead) == $i) selected @endif>{{ $v }}</option>
                @endforeach
            </select>
            @if ($errors->has('is_dead')) <span class="invalid-feedback"> {{ $errors->first('is_dead') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Upload scan/foto KTP</label>
        <div class="col-md-8">
            <img id="preview_file" src="{{ $parent->ktp ? Storage::url($parent->ktp) : asset('/assets/img/img-blank.png') }}" class="rounded w-100 mb-2 border border-light"/>
            @include('admission::form.includes.upload-guide')
            <div class="custom-file">
                <input type="file" class="custom-file-input form-control @error('ktp') is-invalid @enderror" id="ktp" name="ktp" accept="image/*" @if(!$parent->ktp) required @endif >
                <label class="custom-file-label" for="ktp">Choose file</label>
                <small class="text-muted">Kartu Tanda Penduduk, atau identitas kependudukan resmi lainnya</small>
                @error('ktp')
                    <span class="invalid-feedback"> <strong>{{ $message }}</strong> </span> 
                @enderror
            </div>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Pendidikan terakhir {{ $trans }}</label>
        <div class="col-md-5">
            <select name="grade" class="form-control @error('grade') is-invalid @enderror" required>
                <option value="">-- Pilih --</option>
                @foreach (config('web.references.grades') as $v)
                    <option value="{{ $v->id }}" @if(old('grade', $parent->grade_id) == $v->id) selected @endif>{{ $v->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('grade')) <span class="invalid-feedback"> {{ $errors->first('grade') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Pekerjaan {{ $trans }}</label>
        <div class="col-md-5">
            <select name="employment" class="form-control @error('employment') is-invalid @enderror" required>
                <option value="">-- Pilih --</option>
                @foreach (config('web.references.employments') as $v)
                <option value="{{ $v->id }}" @if(old('employment', $parent->employment_id) == $v->id) selected @endif>{{ $v->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('employment')) <span class="invalid-feedback"> {{ $errors->first('employment') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Penghasilan/bulan {{ $trans }}</label>
        <div class="col-md-5">
            <select name="salary" class="form-control @error('salary') is-invalid @enderror" required>
                <option value="">-- Pilih --</option>
                @foreach (config('web.references.salaries') as $v)
                <option value="{{ $v->id }}" @if(old('salary', $parent->salary_id) == $v->id) selected @endif>{{ $v->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('salary')) <span class="invalid-feedback"> {{ $errors->first('salary') }} </span> @endif
        </div>
    </div>
</fieldset>
<hr>
<fieldset>
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <h5 class="text-muted font-weight-normal mb-0">Alamat tinggal {{ $trans }}</h5>
            <p><small class="text-muted">Formulir ini otomatis terisi jika alamat asal calon mahasiswa sudah diisi. Boleh diubah jika alamat {{ $trans }} berbeda dengan alamat calon mahasiswa</small></p>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Alamat lengkap</label>
        <div class="col-md-8">
            <input type="text" class="form-control @error('address') is-invalid @enderror"  name="address" value="{{ old('address', $parent->address ?? $address->address) }}" required>
            <small class="form-text text-muted">Diisi nama jalan, dusun, komplek, atau perumahan</small>
            @if ($errors->has('address')) <span class="invalid-feedback"> {{ $errors->first('address') }} </span> @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">RT</label>
        <div class="col-md-4">
            <input type="text" class="form-control @error('rt') is-invalid @enderror"  name="rt" value="{{ old('rt', $parent->rt ?? $address->rt) }}">
            @if ($errors->has('rt')) <span class="invalid-feedback"> {{ $errors->first('rt') }} </span> @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">RW</label>
        <div class="col-md-4">
            <input type="text" class="form-control @error('rw') is-invalid @enderror"  name="rw" value="{{ old('rw', $parent->rw ?? $address->rw) }}">
            @if ($errors->has('rw')) <span class="invalid-feedback"> {{ $errors->first('rw') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Desa/Kelurahan</label>
        <div class="col-md-8">
            <input type="text" class="form-control @error('village') is-invalid @enderror"  name="village" value="{{ old('village', $parent->village ?? $address->village) }}" required>
            @if ($errors->has('village')) <span class="invalid-feedback"> {{ $errors->first('village') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Kecamatan</label>
        <div class="col-md-8">
            <select class="form-control form-select2 w-100  @error('district') is-invalid @enderror" name="district" data-ajax--url="{{ route('api.search.districts') }}" data-placeholder="Cari nama kecamatan disini, misal 'ngaglik' ..." required>
                @if(old('district', $parent->district_id ?? $address->district_id))
                @php
                    $district = config('web.models.districts')->find(old('district', $parent->district_id ?? $address->district_id));
                    $name = join(', ', [$district->name, $district->regency->name, $district->regency->province->name ]);
                @endphp
                    <option value="{{ $district->id }}">{{ $name }}</option>
                @endif
            </select>
            @if ($errors->has('district')) 
                <span class="invalid-feedback"> {{ $errors->first('district') }} </span> 
            @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Kodepos</label>
        <div class="col-md-6">
            <input type="number" class="form-control @error('postal') is-invalid @enderror"  name="postal" value="{{ old('postal', $parent->postal ?? $address->postal) }}" required>
            @if ($errors->has('postal')) <span class="invalid-feedback"> {{ $errors->first('postal') }} </span> @endif
        </div>
    </div>
</fieldset>
<hr>
<div class="row">
    <div class="col-md-8 offset-md-4">
        <button class="btn btn-success" type="submit">Simpan</button>
        <a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
    </div>
</div>

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#dob').datetimepicker({
                maxDate: moment(),
                useCurrent: false,
                viewMode: 'years',
                format: 'DD-MM-YYYY'
            });
            $('[name="nik"]').mask('0'.repeat(16));
            function readURL(input) {
                if (input.files && input.files[0]) {
                    $('[for="ktp"]').text(input.files[0].name)
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview_file').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('[name="ktp"]').change(function() {
                readURL(this);
            });
        })
    </script>
@endpush