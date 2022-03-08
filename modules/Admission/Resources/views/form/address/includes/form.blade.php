@php

    $address = $registrant->user->address;

@endphp

<fieldset>
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <h5 class="text-muted font-weight-normal mb-3">Alamat asal</h5>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Alamat lengkap</label>
        <div class="col-md-8">
            <input type="text" class="form-control @error('address') is-invalid @enderror"  name="address" value="{{ old('address', $address->address) }}" required autofocus>
            <small class="form-text text-muted">Diisi nama jalan, dusun, komplek, atau perumahan</small>
            @error('address') <span class="invalid-feedback"> {{ $message }} </span> @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">RT</label>
        <div class="col-md-4">
            <input type="text" class="form-control @error('rt') is-invalid @enderror"  name="rt" value="{{ old('rt', $address->rt) }}">
            @error('rt') <span class="invalifd-feedback"> {{ $message }} </span> @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">RW</label>
        <div class="col-md-4">
            <input type="text" class="form-control @error('rw') is-invalid @enderror"  name="rw" value="{{ old('rw', $address->rw) }}">
            @error('rw') <span class="invalid-feedback"> {{ $message }} </span> @enderror
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Desa/Kelurahan</label>
        <div class="col-md-8">
            <input type="text" class="form-control @error('village') is-invalid @enderror"  name="village" value="{{ old('village', $address->village) }}" required>
            @error('village') <span class="invalid-feedback"> {{ $message }} </span> @enderror
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Kecamatan</label>
        <div class="col-md-8">
            <select class="form-control form-select2 w-100 @error('district') is-invalid @enderror" name="district" data-ajax--url="{{ route('api.search.districts') }}" data-placeholder="Cari nama kecamatan disini, misal 'ngaglik' ..." required>
                @if(old('district', $address->district_id))
                @php
                    $district = config('web.models.districts')->find(old('district', $address->district_id));
                    $name = join(', ', [$district->name, $district->regency->name, $district->regency->province->name ]);
                @endphp
                	<option value="{{ $district->id }}">{{ $name }}</option>
                @endif
            </select>
            @error('district') 
            	<span class="invalid-feedback"> {{ $message }} </span> 
            @enderror
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Kodepos</label>
        <div class="col-md-6">
            <input type="number" class="form-control @error('postal') is-invalid @enderror"  name="postal" value="{{ old('postal', $address->postal) }}" required>
            @error('postal') <span class="invalid-feedback"> {{ $message }} </span> @enderror
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
    <script>
        $(() => {
            $('[name="postal"]').mask('00000')
        })
    </script>
@endpush