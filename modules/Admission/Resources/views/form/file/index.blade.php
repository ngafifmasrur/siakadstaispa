@extends('admission::layouts.default')

@section('subtitle', 'Berkas pendaftaran - ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h2 class="mb-0"><a class="text-decoration-none small" href="{{ request('next', url()->previous()) }}"><i class="mdi mdi-arrow-left-circle"></i></a> Berkas pendaftaran</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <p>Berkas pendaftaran digunakan untuk kelengkapan administrasi.</p>
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-0">Upload berkas</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr class="bg-dark text-white">
                                    <th width="1">No.</th>
                                    <th>Formulir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($files as $file)
                                    @php
                                        $reg = $file->registrants->first();
                                    @endphp
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $file->name }} 
                                            @if($file->required)
                                                <small class="text-danger">({!! $file->required_message ?: 'Wajib diunggah' !!})</small>
                                            @elseif(($file->name == 'Kartu BSM' || $file->name == 'Surat Keterangan Tidak Mampu' || $file->name == 'Kartu KIP') && $registrant->is_saman == 1)
                                                <small class="text-danger">(SAMAN Wajib unggah jika punya)</small>
                                            @endif
                                            @if($file->description)
                                                <div>
                                                    <small class="text-muted">{{ $file->description }}</small>
                                                </div>
                                            @endif
                                        </td>
                                        <td nowrap class="align-middle">
                                            @if($reg)
                                                <span class="text-success"><i class="mdi mdi-check-circle-outline"></i> Sudah</span>
                                            @else
                                                <span class="text-danger"><i class="mdi mdi-close-circle-outline"></i> Belum</span>
                                            @endif
                                        </td>
                                        <td nowrap class="py-2 align-middle">
                                            @if($reg)
                                                <a href="{{ Storage::url($reg->pivot->file) }}" target="_blank">Lihat</a> | 
                                                <a href="javascript:;" data-toggle="modal" data-target="#upload-modal" data-title="{{ $file->name }}" data-type="{{ $file->id }}" data-src="{{ (explode('.', $reg->pivot->file)[1] == 'pdf') ? asset('assets/img/img-pdf.png') : Storage::url($reg->pivot->file)  }}">Ubah</a>
                                            @else
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload-modal" data-title="{{ $file->name }}" data-type="{{ $file->id }}"><i class="mdi mdi-cloud-upload"></i> Unggah</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($registrant->is_saman == 1 && $file->name == 'Kartu Keluarga (KK)')
                                        <tr class="bg-dark text-white">
                                            <td colspan="4">SAMAN Wajib Upload salah satu berkas dibawah</td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="4">Tidak ada berkas yang harus diunggah</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body border-top">
                        <a class="btn btn-secondary" href="{{ route('admission.home') }}">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <div id="upload-modal" class="modal" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title lead">Upload <span id="upload-title"></span></div>
                </div>
                <div class="modal-body">
                    <form id="upload-form" enctype="multipart/form-data"> @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <img id="upload-preview" src="{{ asset('assets/img/img-blank.png') }}" class="img-fluid border my-2">
                            </div>
                            <div class="col-lg-6 align-self-center">
                                @include('admission::form.includes.upload-guide')
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" name="file" class="custom-file-input" id="upload-input" required accept="image/*,application/pdf">
                                        <label class="custom-file-label" for="upload-input">Pilih berkas ...</label>
                                    </div>
                                </div>
                                <p id="upload-error" class="text-danger" style="display: none;">Terjadi kesalahan, silahkan baca petunjuk pengunggahan.</p>
                                <div class="form-group mb-0">
                                    <button class="btn btn-success" type="submit">Unggah</button>
                                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    $('[for="upload-input"]').html(input.files[0].name)
                    var reader = new FileReader();
                    if (input.files[0].name.split('.')[1] == 'pdf') {
                        reader.onload = function(e) {
                            $('#upload-preview').attr('src', '{{ asset('assets/img/img-pdf.png') }}');
                        }
                    } else {
                        reader.onload = function(e) {
                            $('#upload-preview').attr('src', e.target.result);
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $('#upload-form').submit((e) => {
                e.preventDefault();
                $('#upload-error').hide(0)
                $('.modal-content').block({message: ''})
                let form = new FormData(e.target)
                $.post({
                    url: $('#upload-form').attr('action'),
                    data: form,
                    cache:false,
                    contentType: false,
                    processData: false,
                    enctype: 'multipart/form-data',
                    success: (r) => {
                        alert(r);
                        history.go(0);
                    },
                    error: (e) => {
                        if(e.responseJSON.errors) {
                            $('#upload-error').html(e.responseJSON.errors.file[0]);
                        } else {
                            $('#upload-error').html('Terjadi kesalahan, silahkan baca petunjuk pengunggahan.')
                        }
                        $('#upload-error').show(0)
                        $('.modal-content').unblock()
                        $.unblockUI()
                    },
                })
            })

            $("#upload-input").change(function(e) {
                readURL(this);
            });

            $('#upload-modal').on('show.bs.modal', (e) => {
                $('#upload-title').html($(e.relatedTarget).data('title'))
                $('#upload-form').attr('action', '{{ route('admission.form.file') }}?type=' + $(e.relatedTarget).data('type'))
                $('#upload-preview').attr('src', $(e.relatedTarget).data('src') || '{{ asset('assets/img/img-blank.png') }}')
            })
        })
    </script>
@endpush