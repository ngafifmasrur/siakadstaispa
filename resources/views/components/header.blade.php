
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="{{ $icon ?? 'grid' }}"></i></div>
                        {{ $slot }}
                    </h1>
                    @isset($sub_title)
                    <div class="page-header-subtitle">{{ $sub_title }}</div>
                    @endisset
                
                </div>
            </div>
        </div>
    </div>
</header>