<form class="form-block" action="{{ route('admission.admin.report.payments.not-paid-off') }}" method="post" id="export-not-paid-off"> @csrf
    <p>
        <input type="hidden" name="aid" value="{{ $admission->id }}">
        Jalur pendaftaran <br> <strong>{{ $admission->full_name }}</strong>
    </p>
    <p>
        Data diambil berdasarkan calon mahasiswa yang sudah ditetapkan jenis pembayarannya dan sampai saat ini belum lunas pembayaran.
    </p>
    <button type="submit" class="btn btn-success"><i class="icon-cloud-download"></i> Unduh laporan (*.xls)</button>
</form>

@push('script')
    <script type="text/javascript">
        $(function () {
            $('#export-not-paid-off').submit((e) => {
                e.preventDefault();
                let form = $(e.target);
                $.post(form.attr('action'), form.serialize())
                    .done((response) => {
                        tableToXls($(response).html(), 'laporan-pembayaran-belum-lunas');
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
