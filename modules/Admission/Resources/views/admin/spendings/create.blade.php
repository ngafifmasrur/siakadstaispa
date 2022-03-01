@extends('admission::admin.layouts.admin')

@section('subtitle', 'Pengeluaran - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item">Pengeluaran</li>
    <li class="breadcrumb-item active">Tambah data</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Tambah data</h2>
        <hr>
        <div class="card">
            <div class="card-body">
                <form class="form-block" action="{{ route('admission.admin.spendings.store') }}" method="POST" enctype="multipart/form-data"> @csrf
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    <label>Nama item</label>
                                    <input type="text" class="form-control @error('item') is-invalid @enderror" name="item" value="{{ old('item') }}" required>
                                    @error('item')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group required">
                                    <label>Harga</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-left-0">@</span>
                                        </div>
                                        <select class="custom-select" name="unit" @error('unit') is-invalid @enderror>
                                            @foreach(\Modules\Admission\Models\AdmissionSpending::$unit as $id => $unit)
                                                <option value="{{ $id }}">{{ $unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label>Qty</label>
                                    <input type="number" class="form-control @error('qty') is-invalid @enderror" name="qty" value="{{ old('qty') }}" required>
                                    @error('qty')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    <label>Divisi</label>
                                    <select class="custom-select" name="committee_id" @error('committee_id') is-invalid @enderror>
                                        @foreach($admissions as $admission)
                                            <optgroup label="{{ $admission->full_name }}">
                                                @foreach($admission->committees as $committee)
                                                    <option value="{{ $committee->id }}">{{ $committee->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group required">
                                    <label>Nama toko</label>
                                    <input type="text" class="form-control @error('shop') is-invalid @enderror" name="shop" value="{{ old('shop') }}" required>
                                    @error('shop')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group required">
                                    <label>Nama pembeli</label>
                                    <input type="text" class="form-control @error('buyer') is-invalid @enderror" name="buyer" value="{{ old('buyer') }}" required>
                                    @error('buyer')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Scan/foto kwitansi</label>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <img id="preview_file" src="{{ asset('/assets/img/img-blank.png') }}" class="img-thumbnail rounded w-100 mb-2"/>
                                </div>
                                <div class="col-sm-8">
                                    @include('admission::form.includes.upload-guide')
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control @error('receipt') is-invalid @enderror" id="receipt" name="receipt" accept="image/*, application/pdf">
                                        <label class="custom-file-label" for="receipt">Choose file</label>
                                        @error('receipt')
                                            <span class="invalid-feedback"> <strong>{{ $message }}</strong> </span> 
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label>Tgl beli</label>
                            <div class="input-group date" id="payed_at" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input @error('payed_at') is-invalid @enderror" name="payed_at" value="{{ old('payed_at') }}" data-toggle="datetimepicker" data-target="#payed_at">
                                <div class="input-group-append" data-target="#payed_at" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="mdi mdi-calendar"></i></div>
                                </div>
                            </div>
                            @error('payed_at')
                                <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                    </fieldset>
                    <hr>
                    <div class="form-group required mb-0">
                        <button class="btn btn-success">Simpan</button>
                        <a href="{{ request('next', url()->previous()) }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#payed_at').datetimepicker({
                format: 'DD-MM-YYYY'
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    $('[for="receipt"]').text(input.files[0].name)
                    var reader = new FileReader();
                    if (input.files[0].name.split('.')[1] == 'pdf') {
                        reader.onload = function(e) {
                            $('#preview_file').attr('src', '{{ asset('assets/img/img-pdf.png') }}');
                        }
                    } else {
                        reader.onload = function(e) {
                            $('#preview_file').attr('src', e.target.result);
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('[name="receipt"]').change(function() {
                readURL(this);
            });
        })
    </script>
@endpush