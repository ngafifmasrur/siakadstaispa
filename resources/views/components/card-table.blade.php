<div class="row">
    <div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="card-title">{{ isset($title) ? $title : 'Data' }}</div>
            <div class="ml-auto">
                {{ isset($button) ? $button : '' }}
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Error, Periksa Ulang data input...</strong>
                <hr class="message-inner-separator">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{ $slot }}
        </div>
        <!-- table-wrapper -->
    </div>
    <!-- section-wrapper -->
    </div>
</div>