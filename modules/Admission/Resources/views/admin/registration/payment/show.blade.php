@extends('admission::admin.layouts.admin')

@section('subtitle', 'Pembayaran - ')

@section('breadcrumb')
	<li class="breadcrumb-item">Pendaftaran</li>
    <li class="breadcrumb-item"><a href="{{ route('admission.admin.registration.payment.index') }}">Pembayaran</a></li>
    <li class="breadcrumb-item active">{{ $registrant->kd }}</li>
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
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-0">Informasi pembayaran</h5>
                </div>
                <div class="card-body border-top">
                    <p>
                        Jenis pembayaran <br>
                        @if($registrant->payment_id)
                            <strong>{{ $registrant->payment->admission->full_name }} - {{ $registrant->payment->name }}</strong>
                        @else
                            <strong>-</strong>
                        @endif
                    </p>
                    <form class="form-block" action="{{ route('admission.admin.registration.payment.paid', ['registrant' => $registrant->id]) }}" method="POST"> @csrf @method('PUT')
                        <div class="form-group">
                            <label class="form-control-label">Status pelunasan</label>
                            <select class="form-control{{ $errors->has('paid') ? ' is-invalid' : '' }}" name="paid">
                                <option value="0" @if($registrant->paid_off_at) selected @endif>Belum lunas</option>
                                <option value="1" @if($registrant->paid_off_at) selected @endif>Lunas</option>
                            </select>
                            @if ($errors->has('paid'))
                                <span class="invalid-feedback"> {{ $errors->first('paid') }} </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Status diterima</label>
                            <select class="form-control{{ $errors->has('accepted') ? ' is-invalid' : '' }}" name="accepted">
                                <option value="0" @if($registrant->accepted_at) selected @endif>Belum diterima</option>
                                <option value="1" @if($registrant->accepted_at) selected @endif>Diterima</option>
                            </select>
                            @if ($errors->has('accepted'))
                                <span class="invalid-feedback"> {{ $errors->first('accepted') }} </span>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-success"><i class="mdi mdi-check"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-0">Riwayat transaksi</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th nowrap>No. kwitansi</th>
                                <th nowrap>Pembayar</th>
                                <th nowrap>Jumlah</th>
                                <th nowrap></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sum = 0;
                            @endphp
                            @forelse($registrant->transactions as $transaction)
                                <tr>
                                    <td>
                                        <strong>{{ $transaction->kd }} </strong><br>
                                        {{ $transaction->payed_at->formatLocalized('%A, %d %b %Y') }}
                                    </td>
                                    <td>
                                        <strong>{{ $transaction->payer }}</strong> <br>
                                        {{ $transaction->cash ? 'TUNAI' : 'NON-TUNAI' }}
                                    </td>
                                    <td class="align-middle text-right">
                                        <span class="float-left">Rp</span> 
                                        {{ number_format($transaction->amount, 0, ',', '.') }}
                                        @php
                                            $sum += $transaction->amount;
                                        @endphp
                                    </td>
                                    <td class="py-2 align-middle">
                                        <a class="btn btn-success btn-sm" href="{{ route('admission.admin.registration.payment.receipt', ['transaction' => $transaction->id]) }}" target="_blank"><i class="mdi mdi-printer"></i> Cetak</a>
                                    </td>
                                </tr>
                                @if($loop->last)
                                    <tr>
                                        <td class="py-1 bg-dark" colspan="2"><strong>JUMLAH</strong></td>
                                        <td class="py-1 text-right"><span class="float-left">Rp</span> {{ number_format($sum, 0, ',', '.') }}</td>
                                        <td class="py-1"></td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4">Tidak ada riwayat transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-body border-top">
                    @if(!$registrant->paid_off_at)
                        @if($registrant->payment_id)
                            <a href="{{ route('admission.admin.registration.payment.create', ['registrant' => $registrant->id]) }}" class="btn btn-success"><i class="mdi mdi-plus"></i> Buat transaksi</a>
                            <a class="btn btn-secondary" href="{{ route('admission.admin.registration.payment.index') }}"><i class="mdi mdi-arrow-left-circle"></i> Kembali</a>
                        @else
                            @if($registrant->admission->payments()->exists())
                                <form class="form-block form-confirm" action="{{ route('admission.admin.registration.payment.set', ['registrant' => $registrant->id]) }}" method="POST"> @csrf @method('PUT')
                                    <div class="form-group">
                                        <label class="form-control-label">Untuk membuat transaksi, silahkan tentukan jenis pembayaran calon mahasiswa terlebih dahulu.</label>
                                        <select class="form-control{{ $errors->has('payment_id') ? ' is-invalid' : '' }}" name="payment_id">
                                            <option value="">-- Pilih --</option>
                                            @foreach($payments as $payment)
                                                <option value="{{ $payment->id }}" @if($registrant->payment_id == $payment->id) selected @endif>{{ $payment->admission->full_name }} - {{ $payment->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('payment_id'))
                                            <span class="invalid-feedback"> {{ $errors->first('payment_id') }} </span>
                                        @endif
                                    </div>
                                    <p class="text-danger">Anda hanya dapat menentukan jenis pembayaran calon mahasiswa satu kali</p>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-check"></i> Simpan</button>
                                    </div>
                                </form>
                            @else
                                <span>Tidak dapat menentukan jenis pembayaran, silahkan hubungi Administrator Pusat.</span>
                            @endif
                        @endif
                    @else
                        <button class="btn btn-secondary" disabled><i class="mdi mdi-plus"></i> Buat transaksi</button>
                        <a class="btn btn-secondary" href="{{ route('admission.admin.registration.payment.index') }}"><i class="mdi mdi-arrow-left-circle"></i> Kembali</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection