<form class="form-block" action="{{ route('admission.admin.report.payments.receipt') }}" method="post" id="export-receipt"> @csrf
    <p>
        <input type="hidden" name="aid" value="{{ $admission->id }}">
        Jalur pendaftaran <br> <strong>{{ $admission->full_name }}</strong>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Dari tanggal</label>
                <input type="text" class="form-control datetimepicker-input{{ $errors->has('from') ? ' is-invalid' : '' }}" id="receipt-from" name="from" value="{{ old('from', date('d-m-Y')) }}" required data-toggle="datetimepicker" data-target="#receipt-from">
                @if ($errors->has('from')) 
                    <span class="invalid-feedback"> <strong>{{ $errors->first('from') }}</strong> </span> 
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Sampai</label>
                <input type="text" class="form-control datetimepicker-input{{ $errors->has('to') ? ' is-invalid' : '' }}" id="receipt-to" name="to" value="{{ old('to', date('d-m-Y')) }}" required data-toggle="datetimepicker" data-target="#receipt-to">
                @if ($errors->has('to')) 
                    <span class="invalid-feedback"> <strong>{{ $errors->first('to') }}</strong> </span> 
                @endif
            </div>
        </div>
    </div>
    <p>Data berupa transaksi pembayaran (kwitansi), silahkan unduh untuk melanjutkan.</p>
    <button type="submit" class="btn btn-success"><i class="icon-cloud-download"></i> Unduh laporan (*.xls)</button>
</form>

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#receipt-from, #receipt-to').datetimepicker({
                format: 'DD-MM-Y',
                date: '{!! date('Y-m-d') !!}',
                useCurrent: true,
            });
            $('#export-receipt').submit((e) => {
                e.preventDefault();
                let form = $(e.target);
                $.post(form.attr('action'), form.serialize())
                    .done((response) => {
                        tableToXls($(response).html(), 'laporan-kwitansi-pembayaran');
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
