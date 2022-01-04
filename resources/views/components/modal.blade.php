<div {{ $attributes->merge([
    "class" => "modal fade",
    "id" => isset($id) ? $id : "exampleModal",
    "role" => "dialog",
    "aria-labelledby" => "exampleModalLabel",
    "aria-hidden" => "true"
]) }}>
    <div class="modal-dialog {{ $modalPosition ?? '' }} {{ $modalDialogClass ?? 'modal-lg' }} " role="document">
        <div class="modal-content">
            <form method="post">
                @isset($title)
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $title ?? 'Text' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endisset
                <div class="modal-body">
                    {{ $slot }}
                </div>
                @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
                @endisset
            </form>
        </div>
    </div>
</div>