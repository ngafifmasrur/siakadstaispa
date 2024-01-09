@extends('admission::admin.layouts.admin')

@section('subtitle', 'Edit Biaya Pesantren - ')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admission.admin.cost_information.index') }}">Biaya Pesantren</a>
    </li>
    <li class="breadcrumb-item active">Edit Biaya Pesantren</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i
                        class="mdi mdi-arrow-left-circle"></i></a> Ubah data Biaya Pesantren</h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form class="form-block"
                        action="{{ route('admission.admin.cost_information.update', [
                            'costInformation' => $costInformation->id,
                            'next' => request('next', url()->previous())
                        ]) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="form-group required row">
                            <label class="col-md-4 col-form-label text-md-right">Nama</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control @error('name') is-invalid @enderror "
                                    name="name" value="{{ old('name', $costInformation->name) }}"
                                    required autofocus>
                                @error('name')
                                    <span class="invalid-feedback"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required row">
                            <label class="col-md-4 col-form-label text-md-right">Detail</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control @error('detail') is-invalid @enderror "
                                    name="detail" value="{{ old('detail', $costInformation->detail) }}"
                                    required autofocus>
                                @error('detail')
                                    <span class="invalid-feedback"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4">
                                <button class="btn btn-success" type="submit">Simpan</button>
                                <a class="btn btn-secondary" href="{{ request('next', url()->previous()) }}">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            // Check the selected type on page load
            if ($("#type").val() == "informasi") {
                $(".content-default").hide();
                $(".content-default input").prop('disabled', true);
                $(".content-textarea").show();
                $(".content-textarea textarea").prop('disabled', false);
            }

            // Update the content input to textarea on type change
            $("#type").change(function() {
                if ($(this).val() == "informasi") {
                    $(".content-default").hide();
                    $(".content-default input").prop('disabled', true);
                    $(".content-textarea").show();
                    $(".content-textarea textarea").prop('disabled', false);

                } else {
                    $(".content-default").show();
                    $(".content-default input").prop('disabled', false);
                    $(".content-textarea").hide();
                    $(".content-textarea textarea").prop('disabled', true);

                }
            });
        });
    </script>
@endpush
