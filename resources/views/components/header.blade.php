<div class="page-header">
    <ol class="breadcrumb"><!-- breadcrumb -->
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <?php
            $segments = '';
            $total_segments = count(Request::segments());
        ?>
        @foreach(Request::segments() as $key => $segment)
            <?php $segments .= '/'.$segment; ?>
            <li class="breadcrumb-item {{ $key+1 == $total_segments ? 'active' : ''}}" aria-current="page">{{ ucwords(str_replace('_', ' ',$segment)) }}</li>
        @endforeach
    </ol>
</div>