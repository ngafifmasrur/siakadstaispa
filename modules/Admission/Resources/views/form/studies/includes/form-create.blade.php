<fieldset>
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <h5 class="text-muted font-weight-normal mb-3">Data sekolah/madrasah</h5>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Jenjang sekolah/madrasah</label>
        <div class="col-md-8">
            <select class="form-control @error('grade') is-invalid @enderror" name="grade" required>
                <option value="">-- Pilih --</option>
                @foreach(config('web.references.grades')->take(config('admission.maximum-grades', 5)) as $grade)
                    <option value="{{ $grade->id }}" @if(old('grade') == $grade->id) selected @endif>{{ $grade->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('grade')) <span class="invalid-feedback"> {{ $errors->first('grade') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Nama sekolah/madrasah</label>
        <div class="col-md-8">
            <input type="text" class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ old('name') }}" required>
            <small class="form-text text-muted">Ditulis menggunakan huruf kapital beserta status sekolah (negeri atau swasta)</small>
            @if ($errors->has('name')) <span class="invalid-feedback"> {{ $errors->first('name') }} </span> @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">NPSN</label>
        <div class="col-md-6">
            <input type="number" class="form-control @error('npsn') is-invalid @enderror"  name="npsn" value="{{ old('npsn') }}">
            <small class="form-text text-muted">Nomor Pokok Sekolah Nasional, dapat dicek langsung <a href="http://referensi.data.kemdikbud.go.id/index11.php" target="_blank">disini</a></small>
            @if ($errors->has('npsn')) <span class="invalid-feedback"> {{ $errors->first('npsn') }} </span> @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">NSS/NSM</label>
        <div class="col-md-6">
            <input type="number" class="form-control @error('nss') is-invalid @enderror"  name="nss" value="{{ old('nss') }}">
            <small class="form-text text-muted">Nomor Statistik Sekolah/Madrasah</small>
            @if ($errors->has('nss')) <span class="invalid-feedback"> {{ $errors->first('nss') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Dari tahun</label>
        <div class="col-md-4">
            <input type="number" class="form-control datetimepicker-input  @error('from') is-invalid @enderror"  name="from" value="{{ old('from') }}"  data-toggle="datetimepicker" data-target='[name="from"]' autocomplete="off" required>
            @if ($errors->has('from')) <span class="invalid-feedback"> {{ $errors->first('from') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Sampai</label>
        <div class="col-md-4">
            <input type="number" class="form-control datetimepicker-input  @error('to') is-invalid @enderror"  name="to" value="{{ old('to') }}"  data-toggle="datetimepicker" data-target='[name="to"]' autocomplete="off" required>
            @if ($errors->has('to')) <span class="invalid-feedback"> {{ $errors->first('to') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Alamat sekolah</label>
        <div class="col-md-8">
            <select class="form-control form-select2 w-100  @error('district') is-invalid @enderror" name="district"  data-ajax--url="{{ route('api.search.districts') }}" data-placeholder="Cari nama kecamatan disini, misal 'ngaglik' ..." required>
                @if(old('district'))
                    @php
                        $district = config('web.models.districts')->with('regency.province')->find(old('district'));
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


@push('script')
    <script type="text/javascript">
        $(function () {
            $('[name="from"],[name="to"]').datetimepicker({
                useCurrent: false,
                viewMode: 'years',
                format: 'YYYY'
            });;
        })
    </script>
@endpush