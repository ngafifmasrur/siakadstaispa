@if($type == 'button')

<button type="button"
    data-route="{{ isset($route) ? $route : '#' }}"
    class="{{isset($class) ? $class : 'btn btn-outline-primary btn-md'}}" 
    
    @if(isset($tooltip))
        data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$tooltip}}"
    @endif

    @if(isset($attribute) && is_array($attribute))
        @if(isset($disabled)) {{$disabled}} @endif
        @foreach($attribute as $key=> $row)
            {{$key}}="{{$row}}"
        @endforeach
    @endif style="{{isset($style) ? $style : ''}}">
    @if(isset($icon)) <i class="{{$icon}}"></i> @endif @if(isset($label))<span> {{ $label }} </span>@endif
</button>

@else

<a href="{{ isset($route) ? $route : '#' }}"

    @if(isset($tooltip))
        data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$tooltip}}"
    @endif

    @if(isset($attribute) && is_array($attribute))

        @foreach($attribute as $key=> $row)
            {{$key}}="{{$row}}"
        @endforeach
    @endif
    
    class="{{isset($class) ? $class : 'btn btn-outline-primary btn-md'}}" style="{{isset($style) ? $style : ''}}">
    @if(isset($icon)) <i class="{{$icon}}"></i> @endif @if(isset($label))<span> {{ $label }} </span>@endif
</a>
@endif
