@if($registrant->verified_at)
	@if($registrant->tested_at)
		@if($registrant->paid_off_at)
			@if($registrant->accepted_at)
				<span class="badge badge-success badge-pill font-weight-normal"><i class="mdi mdi-check-circle-outline"></i> Diterima</span>
			@else
				<span class="badge badge-success badge-pill font-weight-normal"><i class="mdi mdi-check-circle-outline"></i> Lunas pembayaran</span>
			@endif
		@else
			@if($registrant->accepted_at)
				<span class="badge badge-warning badge-pill font-weight-normal"><i class="mdi mdi-clock-outline"></i> Diterima belum lunas</span>
			@else
				@if($registrant->transactions()->exists())
					<span class="badge badge-dark badge-pill font-weight-normal"><i class="mdi mdi-close-circle-outline"></i> Belum lunas</span>
				@else
					@if($registrant->validated_at)
						<span class="badge badge-success badge-pill font-weight-normal"><i class="mdi mdi-check-circle-outline"></i> Data valid </span>
					@else
						<span class="badge badge-success badge-pill font-weight-normal"><i class="mdi mdi-check-circle-outline"></i> Lulus tes</span>
					@endif
				@endif
			@endif
		@endif
		@if(!$registrant->validated_at)
			<span class="badge badge-warning badge-pill font-weight-normal"><i class="mdi mdi-close-circle-outline"></i> Data belum valid </span>
		@endif
	@else
		@if($registrant->tests()->exists())
			<span class="badge badge-warning badge-pill font-weight-normal"><i class="mdi mdi-clock-outline"></i> Belum lulus tes</span>
		@else
			<span class="badge badge-info badge-pill font-weight-normal"><i class="mdi mdi-check-circle-outline"></i> Terverifikasi</span>
		@endif
	@endif
@else
	<span class="badge badge-secondary badge-pill font-weight-normal">
        <i class="mdi mdi-clock-outline"></i> Belum verifikasi
    </span>
@endif

<span class="badge badge-light badge-pill font-weight-normal">
    {{ $registrant->is_saman ? 'SAMAN' : 'REGULER' }}
</span>
