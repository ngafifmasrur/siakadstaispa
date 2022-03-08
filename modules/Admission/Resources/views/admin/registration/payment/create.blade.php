@extends('admission::admin.layouts.admin')

@section('subtitle', 'Pembayaran - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pendaftaran</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.registration.payment.index') }}">Pembayaran</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.registration.payment.show', ['registrant' => $registrant->id]) }}">{{ $registrant->kd }}</a></li>
    <li class="breadcrumb-item active">Buat transaksi</li>
@endsection

@section('section')
	<div class="section">
	    <h3 class="mb-1">Pembayaran</h3>
	    <div class="mb-2">Kelola bagian pembayaran calon mahasiswa.</div>
	</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('admission::includes.registrant-information', ['registrant' => $registrant, 'simple' => true])
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0">Buat transaksi</h5>
                </div>
                @if(count($payments))
                    <form class="table-responsive" action="{{ route('admission.admin.registration.payment.store', ['registrant' => $registrant->id]) }}" method="POST"> @csrf
                        <table class="table table-sm table-bordered table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="pl-3">
                                        <label for="checkall" class="mb-0">
                                            <input id="checkall" type="checkbox">
                                            <span>Item pembayaran</span>
                                        </label>
                                    </th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments->sortBy('category_id')->groupBy('category.name') as $category => $items)
                                    @if($items)
                                        <tr class="bg-light">
                                            <td colspan="2" class="pl-3"><strong>{{ $category ?: 'Lain-lain' }}</strong></td>
                                        </tr>
                                        @foreach($items->sortBy('id') as $item)
                                            <tr class="toggle-checkbox">
                                                <td class="pl-3">
                                                    <label for="item{{ $item->id }}" class="mb-0">
                                                        <input class="payment" id="item{{ $item->id }}" type="checkbox" name="item[{{ $item->id }}]" value="{{ $item->amount }}" @if(in_array($item->id, array_keys(old('item', [])))) checked @endif>
                                                        <span>{{ $item->name }}</span>
                                                    </label>
                                                </td>
                                                <td class="text-right pr-3" nowrap width="180">
                                                    @if($item->minimum)
                                                        <button type="button" class="btn btn-link p-0 d-inline btn-block text-right" data-toggle="modal" data-target="#modal-change-amount" data-item="{{ $item }}">
                                                            <span class="float-left pr-2">Rp </span><span id="item-amount-{{ $item->id }}">{{ number_format($item->amount, 0, ',', '.') }}</span>
                                                        </button>
                                                    @else
                                                        <span class="float-left pr-2">Rp </span>{{ number_format($item->amount, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                <tr>
                                    <td class="bg-dark pl-3"><strong>JUMLAH</strong></td>
                                    <td class="text-right pr-3 text-danger"><strong><span class="float-left pr-2">Rp </span><span id="sum">0</span></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-danger px-3"><i>Terbilang: <span id="sumtext">nol</span> rupiah</i></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Waktu membayar</label>
                                        <input type="text" class="form-control{{ $errors->has('payed_at') ? ' is-invalid' : '' }}" name="payed_at" value="{{ old('payed_at', date('d-m-Y H:i:s')) }}" required>
                                        @if ($errors->has('payed_at'))
                                            <span class="invalid-feedback"> {{ $errors->first('payed_at') }} </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Nama pembayar</label>
                                        <input type="text" class="form-control{{ $errors->has('payer') ? ' is-invalid' : '' }}" name="payer" value="{{ old('payer') }}" required>
                                        @if ($errors->has('payer'))
                                            <span class="invalid-feedback"> {{ $errors->first('payer') }} </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Catatan</label>
                                        <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" style="height: 7.5rem;">{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback"> {{ $errors->first('description') }} </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="cash" value="1" checked name="cash">
                                    <label class="form-check-label" for="cash">Dibayar secara <strong id="cashtext">tunai</strong></label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="form-control-label">Masukkan password!</label>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback"> {{ $errors->first('password') }} </span>
                                @endif
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success"><i class="mdi mdi-check"></i> Simpan</button>
                                <a class="btn btn-secondary" href="{{ route('admission.admin.registration.payment.show', ['registrant' => $registrant->id]) }}"><i class="mdi mdi-arrow-left-circle"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="card-body border-top">
                        <p>Semua item pembayaran telah dibayar</p>
                        <a href="{{ route('admission.admin.registration.payment.show', ['registrant' => $registrant->id]) }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left-circle"></i> Kembali</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <div class="modal fade" id="modal-change-amount" tabindex="-1" role="dialog" aria-labelledby="modal-change-amount" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-dialog-scrollable|modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-change-amount">Ubah nominal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="d-none" id="modal-item-id"></span>
                    <div class="form-group">
                        <label>Nama item</label>
                        <div><strong id="modal-item-name"></strong></div>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nominal" id="modal-item-value">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="modal-item-save">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(() => {
            $('#modal-item-value').mask('#.##0', {reverse: true});
            $('[name="payed_at"]').mask('00-00-0000 00:00:00');
            $('[type="checkbox"].payment').click(() => { sum(); });
            $('tr.toggle-checkbox').on('click', (e) => {
                let c = $(this).find(':checkbox');
                c.click();
            });
            $('#checkall').on('click', (e) => {
                $('[type="checkbox"].payment').each(function() {
                    $(this).prop('checked', $(e.target).is(':checked'));
                    sum();
                });
            });
            $('#cash').on('click', (e) => {
                $('#cashtext').text($(e.target).is(':checked') ? 'tunai' : 'non-tunai')
            });
            $('#modal-change-amount').on('show.bs.modal', (e) => {
                var button = $(e.relatedTarget);
                var item = button.data('item');
                $('#modal-item-name').text(item.name);
                $('#modal-item-id').text(item.id);
                $('#modal-item-value').val(toMoney(item.amount, 0, ',', '.'));
            });
            $('#modal-item-value').keypress(function (e) {
                if(e.which == 13) {
                    $('#modal-item-save').click();
                }
            });   
            $('#modal-item-save').click(() => {
                var value = $('#modal-item-value');
                var id = $('#modal-item-id').text();
                $('#item-amount-' + id).html(value.val());
                $('input[name="item[' + id + ']"]').attr('value', value.unmask().val());
                $('#modal-change-amount').modal('hide');
                sum();
            });
        });
        function sum() {
            var sum = 0;
            $('[type="checkbox"].payment:checked').each(function(){
                var amt = parseInt($(this).val());
                sum += amt;
            });
            $('#sum').text(toMoney(sum, 0, ',', '.'));
            $('#sumtext').text(toMoneySpeech(sum).toLowerCase());
        }
    </script>
@endpush