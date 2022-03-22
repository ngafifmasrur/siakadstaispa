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
        <label class="col-md-4 col-form-label text-md-right">Nama lengkap {{ $trans }}</label>
        <div class="col-md-8">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $parent->name) }}" required>
            <small class="form-text text-muted">Diisi dengan menggunakan huruf kapital dan sesuai KTP/KK/Identitas lainnya, tidak menggunakan gelar</small>
            @if ($errors->has('name')) <span class="invalid-feedback"> {{ $errors->first('name') }} </span> @endif
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