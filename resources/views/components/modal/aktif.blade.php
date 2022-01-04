<div class="modal fade" id="ModalAktif" tabindex="-1" role="dialog" aria-labelledby="aktif_title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aktif_title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="form_aktif" method="POST">
                    @csrf
                    <p id="aktif_text"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close
                </button>
                <button class="btn btn-warning" type="button" id="btn_submit_aktif" onclick="document.getElementById('form_aktif').submit();">
                    
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function(){
        $(document).on('click','.btn_aktif',function(){
            let route = $(this).data('route');
            let title = $(this).data('title');
            let text = $(this).data('text');
            
            $('#aktif_title').html(title);
            $('#btn_submit_aktif').html(title);
            $('#aktif_text').html(text);
            $('#form_aktif').attr('action',route);
            $('#ModalAktif').modal('show');
        });
    });
</script>
@endpush