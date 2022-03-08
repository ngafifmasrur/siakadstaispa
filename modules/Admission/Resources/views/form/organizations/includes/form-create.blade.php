<fieldset>
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <h5 class="text-muted font-weight-normal">Data utama</h5>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Nama organisasi</label>
        <div class="col-md-8">
            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
            <small class="form-text text-muted">Nama organisasi lengkap, bukan singkatan atau kependekan</small>
            @if ($errors->has('name')) <span class="invalid-feedback"> {{ $errors->first('name') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Jenis organisasi</label>
        <div class="col-md-5">
            <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" required>
                <option value="">-- Pilih --</option>
                @foreach (config('web.references.organization_types') as $v)
                    <option value="{{ $v->id }}" @if(old('type') == $v->id) selected @endif>{{ $v->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('type')) <span class="invalid-feedback"> {{ $errors->first('type') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Tahun</label>
        <div class="col-md-4">
            <input type="number" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" name="year" value="{{ old('year') }}" required>
            @if ($errors->has('year')) <span class="invalid-feedback"> {{ $errors->first('year') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Lama menjabat</label>
        <div class="col-md-4">
            <div class="input-group">
                <input type="number" class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}" name="duration" value="{{ old('duration') }}" required>
                <div class="input-group-append">
                    <span class="input-group-text">tahun</span>
                </div>
            </div>
            @if ($errors->has('duration')) <span class="invalid-feedback"> {{ $errors->first('duration') }} </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Jabatan</label>
        <div class="col-md-5">
            <select name="position" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}" required>
                <option value="">-- Pilih --</option>
                @foreach (config('web.references.organization_positions') as $v)
                    <option value="{{ $v->id }}" @if(old('position') == $v->id) selected @endif>{{ $v->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('position')) <span class="invalid-feedback"> {{ $errors->first('position') }} </span> @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">Bukti keorganisasian</label>
        <div class="col-md-5">
            <img id="preview_file" src="{{ asset('/assets/img/img-blank.png') }}" class="w-100 img-thumbnail mb-2"/>
            @include('admission::form.includes.upload-guide')
            <div class="custom-file">
                <input type="file" class="custom-file-input form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" id="file" name="file" accept="image/*">
                <label class="custom-file-label" for="file">Choose file</label>
                @if ($errors->has('file')) <span class="invalid-feedback"> {{ $errors->first('file') }} </span> @endif
            </div>
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
            function readURL(input) {
                if (input.files && input.files[0]) {
                    $('[for="file"]').text(input.files[0].name)
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview_file').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('[name="file"]').change(function() {
                readURL(this);
            });
            $('[name="year"]').mask('0000');
        })
    </script>
@endpush