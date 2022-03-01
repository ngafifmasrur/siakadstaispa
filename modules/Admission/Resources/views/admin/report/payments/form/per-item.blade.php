<form class="form-block" action="{{ route('admission.admin.report.payments.per-item') }}" method="post" id="export-per-item"> @csrf
    <p>
        <input type="hidden" name="aid" value="{{ $admission->id }}">
        Jalur pendaftaran <br> <strong>{{ $admission->full_name }}</strong>
    </p>
    <div class="form-group">
        <label>Jenis pembayaran</label>
        <select class="form-control" name="payment" required>
            @foreach($admission->payments as $payment)
                <option value="{{ $payment->id }}" @if(request('payment') == $payment->id) selected @endif> {{ $payment->name }} </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Metode pembayaran</label>
        <select class="form-control" name="cash">
            <option value="">SEMUA METODE PEMBAYARAN</option>
            @foreach(\Modules\Admission\Models\AdmissionRegistrantTransaction::$cash as $id => $_c)
                <option value="{{ $id + 1 }}" @if(request('cash') == $_c) selected @endif> {{ $_c }} </option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Dari tanggal</label>
                <input type="text" class="form-control datetimepicker-input{{ $errors->has('from') ? ' is-invalid' : '' }}" id="per-item-from" name="from" value="{{ old('from', date('d-m-Y')) }}" required data-toggle="datetimepicker" data-target="#per-item-from">
                @if ($errors->has('from')) 
                    <span class="invalid-feedback"> <strong>{{ $errors->first('from') }}</strong> </span> 
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Sampai</label>
                <input type="text" class="form-control datetimepicker-input{{ $errors->has('to') ? ' is-invalid' : '' }}" id="per-item-to" name="to" value="{{ old('to', date('d-m-Y')) }}" required data-toggle="datetimepicker" data-target="#per-item-to">
                @if ($errors->has('to')) 
                    <span class="invalid-feedback"> <strong>{{ $errors->first('to') }}</strong> </span> 
                @endif
            </div>
        </div>
    </div>
    <p>Data berupa rekap pembayaran per item pembayaran, silahkan unduh untuk melanjutkan.</p>
    <button type="submit" class="btn btn-success"><i class="icon-cloud-download"></i> Unduh laporan (*.xls)</button>
</form>

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#per-item-from, #per-item-to').datetimepicker({
                format: 'DD-MM-Y',
                date: '{!! date('Y-m-d') !!}',
                useCurrent: true,
            });
            $('#export-per-item').submit((e) => {
                e.preventDefault();
                let form = $(e.target);
                $.post(form.attr('action'), form.serialize())
                    .done((response) => {
                        tableToXls($(response).html(), 'rekap-pembayaran');
                        $.unblockUI();
                    })
                    .fail((error) => {
                        $.unblockUI();
                        if(!(form).has('.alert-danger').length) 
                            form.prepend($.alert.error());
                    })
            });
        })
    </script>
@endpush
