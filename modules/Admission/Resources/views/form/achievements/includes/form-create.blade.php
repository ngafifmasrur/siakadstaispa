<fieldset>
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <h5 class="text-muted font-weight-normal">Data utama</h5>
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Nama prestasi</label>
        <div class="col-md-8">
            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
            <small class="form-text text-muted">Dapat berupa perlombaan atau karya</small>
            @if ($errors->has('name')) <span class="invalid-feedback"> <strong>{{ $errors->first('name') }}</strong> </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Jenis prestasi</label>
        <div class="col-md-5">
            <select name="type" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" required>
                <option value="">-- Pilih --</option>
                @foreach (config('web.references.achievement_types') as $v)
                    <option value="{{ $v->id }}" @if(old('type') == $v->id) selected @endif>{{ $v->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('type')) <span class="invalid-feedback"> <strong>{{ $errors->first('type') }}</strong> </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Tahun</label>
        <div class="col-md-4">
            <input type="number" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" name="year" value="{{ old('year') }}" required>
            @if ($errors->has('year')) <span class="invalid-feedback"> <strong>{{ $errors->first('year') }}</strong> </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Peringkat</label>
        <div class="col-md-5">
            <select name="num" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" required>
                <option value="">-- Pilih --</option>
                @foreach (config('web.references.achievement_nums') as $v)
                    <option value="{{ $v->id }}" @if(old('num') == $v->id) selected @endif>{{ $v->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('num')) <span class="invalid-feedback"> <strong>{{ $errors->first('num') }}</strong> </span> @endif
        </div>
    </div>
    <div class="form-group required row">
        <label class="col-md-4 col-form-label text-md-right">Tingkat</label>
        <div class="col-md-5">
            <select name="territory" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" required>
                <option value="">-- Pilih --</option>
                @foreach (config('web.references.territories') as $v)
                    <option value="{{ $v->id }}" @if(old('territory') == $v->id) selected @endif>{{ $v->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('territory')) <span class="invalid-feedback"> <strong>{{ $errors->first('territory') }}</strong> </span> @endif
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">Bukti keikutsertaan</label>
        <div class="col-md-5">
            <img id="preview_file" src="{{ asset('/assets/img/img-blank.png') }}" class="w-100 img-thumbnail mb-2"/>
            @include('admission::form.includes.upload-guide')
            <div class="custom-file">
                <input type="file" class="custom-file-input form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" id="file" name="file" accept="image/*">
                <label class="custom-file-label" for="file">Choose file</label>
                @if ($errors->has('file')) <span class="invalid-feedback"> <strong>{{ $errors->first('file') }}</strong> </span> @endif
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