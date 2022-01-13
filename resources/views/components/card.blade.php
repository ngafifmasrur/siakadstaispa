<div class="row">
    <div class="col-md-12 col-lg-12">
    <div class="card">
        {{-- <div class="card-header pb-0">
            <div class="card-title">{{ isset($title) ? $title : 'Data' }}</div>
            <div class="ml-auto">
                {{ isset($button) ? $button : '' }}
            </div>
        </div> --}}
        <div class="card-body">

            {{ $slot }}
        </div>
        <!-- table-wrapper -->
    </div>
    <!-- section-wrapper -->
    </div>
</div>