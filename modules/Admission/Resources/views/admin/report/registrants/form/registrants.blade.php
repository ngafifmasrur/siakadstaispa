@php
$stats = [
    'verified_at' => 'Terverifikasi',
    // 'tested_at' => 'Lulus tes',
    // 'validated_at' => 'Sudah validasi',
    'paid_off_at' => 'Lunas pembayaran',
    // 'room_id' => 'Dapat kamar'
];
@endphp

<form class="form-block" action="{{ route('admission.admin.report.registrants.registrants') }}" method="post" id="export-registrants"> @csrf
    <p>
        <input type="hidden" name="aid" value="{{ $admission->id }}">
        Jalur pendaftaran <br> <strong>{{ $admission->full_name }}</strong>
    </p>
    <div class="form-group">
        <label class="form-control-label">Filter</label>
        @foreach($stats as $stat => $label)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $stat }}" id="filter-{{ $stat }}" name="filter[]">
                <label class="form-check-label" for="filter-{{ $stat }}">{{ $label }}</label>
            </div>
        @endforeach
    </div>
    <p id="export-registrants-info" class="text-danger"> Tidak ada filter yang diterapkan, pengunduhan data (termasuk yang belum diverifikasi) akan menjadi lambat, tekan tombol dibawah untuk melanjutkan pengunduhan.</p>
    <button type="submit" class="btn btn-success"><i class="icon-cloud-download"></i> Unduh laporan (*.xls)</button>
</form>

@push('script')
    <script type="text/javascript">
        $(() => {
            $('#export-registrants [name="filter[]"]').change(() => {
                ($('#export-registrants [name="filter[]"]:checked').length == 0)
                ? $('#export-registrants-info').show()
                : $('#export-registrants-info').hide();
            });
            $('#export-registrants').submit((e) => {
                e.preventDefault();
                let form = $(e.target);
                $.post(form.attr('action'), form.serialize())
                    .done((response) => {
                        tableToXls($(response).html(), 'laporan-pendaftaran-calon-mahasiswa-baru');
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
