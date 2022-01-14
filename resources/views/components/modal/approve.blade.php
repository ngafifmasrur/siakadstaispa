<div class="modal fade" id="ModalSetujui" tabindex="-1" role="dialog" aria-labelledby="setujui_title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setujui_title">Verifikasi KRS</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="form_setujui" method="POST">
                    @csrf
                    <p id="setujui_text"></p>
                    <div id="catatan"></div>
                    <input type="hidden" name="status">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close
                </button>
                <button class="btn btn-success" type="button" id="btn_submit_setujui" onclick="document.getElementById('form_setujui').submit();">
                    
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function(){
        $(document).on('click','.btn_setujui',function(){
            let route = $(this).data('route');
            let text = $(this).data('text');
            var status = $(this).data('status');

            document.getElementById("btn_submit_setujui").innerText = status;
            if(status == 'Tolak') {
                $('#catatan').html('<strong>Catatan Revisi: </storng></ br><textarea class="form-control" name="catatan_krs" cols="10" rows="5"></textarea>');
            } else {
                $('#catatan').html('');
            }
            $('[name=status]').val(status);
            $('#setujui_text').html(text);
            $('#form_setujui').attr('action',route);
            $('#ModalSetujui').modal('show');
        });
    });
</script>
@endpush