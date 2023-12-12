<div class="row text-muted">
	<div class="col-md-6 text-center text-md-left">
        @isset($activeInformation)
        <div class="w-80">
            <h6 class="font-weight-bold">Informasi</h6>
            <p>
                {{ $activeInformation->content }}
            </p>
        </div>
        @endisset
	</div>
	<div class="col-md-6 text-left text-md-right">
        @isset($activePhoneNumber)
        <div class="mb-3">
            <h6 class="font-weight-bold">Telepon</h6>
            {{ $activePhoneNumber->content }}
        </div>
        @endisset
        @isset($activeEmail)
        <div class="mb-3">
            <h6 class="font-weight-bold">Email</h6>
            {{ $activeEmail->content }}
        </div>
        @endisset
        @isset($activeWebsite)
        <div class="mb-3">
            <h6 class="font-weight-bold">Website</h6>
            {{ $activeWebsite->content }}
        </div>
        @endisset
	</div>
</div>
