<div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog" aria-labelledby="title_{{$modalId}}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{isset($class) ? $class : ''}}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_{{$modalId}}">{{isset($title) ? $title : ''}}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
            <div class="modal-footer">

                @if(isset($footer))
                    {{$footer}}
                @else
                    <button class="btn btn-light" type="button" data-dismiss="modal">Close
                    </button>
                    <button class="btn btn-primary" type="button" id="btn_modal">
                        {{$textButton}}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>