<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="delete_title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_title">Hapus</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="form_delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <p id="delete_text"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close
                </button>
                <button class="btn btn-danger" type="button" id="btn_submit_delete" onclick="document.getElementById('form_delete').submit();">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function(){
        $(document).on('click','.btn_delete',function(){
            let route = $(this).data('route');
            let text = $(this).data('text');
            
            $('#delete_text').html(text);
            $('#form_delete').attr('action',route);
            $('#ModalDelete').modal('show');
        });
    });
</script>
@endpush