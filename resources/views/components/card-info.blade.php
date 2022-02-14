<div class="card">
    <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
    <div class="card-header pb-0">
        <h3 class="card-title">{{ isset($title) ? $title : 'Informasi' }}</h3>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>