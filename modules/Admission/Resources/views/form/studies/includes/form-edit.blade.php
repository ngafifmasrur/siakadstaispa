<fieldset>
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <h5 class="text-muted font-weight-normal mb-3">Data sekolah/madrasah</h5>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Jenjang sekolah/madrasah</label>
        <div class="col-md-8">
            <select class="form-control{{ $errors->has('grade') ? ' is-invalid' : '' }}" name="grade" required>
                <option value="">-- Pilih --</option>
                @foreach(config('web.references.grades')->take(config('admission.maximum-grades', 5)) as $grade)
                    <option value="{{ $grade->id }}" @if(old('grade', $study->grade_id) == $grade->id) selected @endif>{{ $grade->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('grade')) <span class="invalid-feedback"> {{ $errors->first('grade') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Nama sekolah/madrasah</label>
        <div class="col-md-8">
            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"  name="name" value="{{ old('name', $study->name) }}" required>
            <small class="form-text text-muted">Ditulis menggunakan huruf kapital beserta status sekolah (negeri atau swasta)</small>
            @if ($errors->has('name')) <span class="invalid-feedback"> {{ $errors->first('name') }} </span> @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">NPSN</label>
        <div class="col-md-6">
            <input type="number" class="form-control{{ $errors->has('npsn') ? ' is-invalid' : '' }}"  name="npsn" value="{{ old('npsn', $study->npsn) }}">
            <small class="form-text text-muted">Nomor Pokok Sekolah Nasional, dapat dicek langsung <a href="http://referensi.data.kemdikbud.go.id/index11.php" target="_blank">disini</a></small>
            @if ($errors->has('npsn')) <span class="invalid-feedback"> {{ $errors->first('npsn') }} </span> @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">NSS/NSM</label>
        <div class="col-md-6">
            <input type="number" class="form-control{{ $errors->has('nss') ? ' is-invalid' : '' }}"  name="nss" value="{{ old('nss', $study->nss) }}">
            <small class="form-text text-muted">Nomor Statistik Sekolah/Madrasah</small>
            @if ($errors->has('nss')) <span class="invalid-feedback"> {{ $errors->first('nss') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Dari tahun</label>
        <div class="col-md-4">
            <input type="number" class="form-control {{ $errors->has('from') ? ' is-invalid' : '' }}"  name="from" value="{{ old('from', $study->from) }}"  required>
            @if ($errors->has('from')) <span class="invalid-feedback"> {{ $errors->first('from') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Sampai</label>
        <div class="col-md-4">
            <input type="number" class="form-control {{ $errors->has('to') ? ' is-invalid' : '' }}"  name="to" value="{{ old('to', $study->to) }}"  required>
            @if ($errors->has('to')) <span class="invalid-feedback"> {{ $errors->first('to') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Alamat sekolah</label>
        <div class="col-md-8">
            <select class="form-control form-select2 w-100 {{ $errors->has('district') ? ' is-invalid' : '' }}" name="district" data-ajax--url="{{ route('api.search.districts') }}" data-placeholder="Cari nama kecamatan disini, misal 'ngaglik' ..." required>
                @if(old('district', $study->district_id))
                    @php
                        $district = config('web.models.districts')->find(old('district', $study->district_id));
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
</fieldset>
<hr>
<div class="row">
    <div class="col-md-8 offset-md-4">
        <button class="btn btn-success" type="submit">Simpan</button>
        <a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
    </div>
</div>