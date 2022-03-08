<form action="{{ route('admission.admin.report.payments.payments') }}" method="post" id="export-payments" target="_blank"> @csrf
    <p>
        <input type="hidden" name="aid" value="{{ $admission->id }}">
        Jalur pendaftaran <br> <strong>{{ $admission->full_name }}</strong>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Dari tanggal</label>
                <input type="text" class="form-control datetimepicker-input{{ $errors->has('from') ? ' is-invalid' : '' }}" id="payments-from" name="from" value="{{ old('from', date('d-m-Y')) }}" required data-toggle="datetimepicker" data-target="#payments-from">
                @if ($errors->has('from')) 
                    <span class="invalid-feedback"> <strong>{{ $errors->first('from') }}</strong> </span> 
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Sampai</label>
                <input type="text" class="form-control datetimepicker-input{{ $errors->has('to') ? ' is-invalid' : '' }}" id="payments-to" name="to" value="{{ old('to', date('d-m-Y')) }}" required data-toggle="datetimepicker" data-target="#payments-to">
                @if ($errors->has('to')) 
                    <span class="invalid-feedback"> <strong>{{ $errors->first('to') }}</strong> </span> 
                @endif
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success"><i class="icon-cloud-download"></i> Unduh laporan (*.pdf)</button>
</form>

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#payments-from, #payments-to').datetimepicker({
                format: 'DD-MM-Y',
                date: '{!! date('Y-m-d') !!}',
                useCurrent: true,
            });
        })
    </script>
@endpush
