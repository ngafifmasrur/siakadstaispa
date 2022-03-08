<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0">
				<h5 class="modal-title">Contoh foto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card-group">
					<div class="card">
						<div class="card-header h6 mb-0 font-weight-bold">Putra</div>
						<div class="card-body">
							<img src="{{ asset('/assets/img/sample-avatar-l.jpg') }}" class="rounded w-100 mb-2"/>
							<ul class="pl-3">
								<li>Berlatar warna merah</li>
								<li>Foto harus memiliki rasio 3:4</li>
								<li>Tidak berkacamata</li>
								<li>Bersongkok hitam dan berseragam/kemeja warna putih (bukan kaos)</li>
							</ul>
						</div>
					</div>
					<div class="card">
						<div class="card-header h6 mb-0 font-weight-bold">Putri</div>
						<div class="card-body">
							<img src="{{ asset('/assets/img/sample-avatar-p.jpg') }}" class="rounded w-100 mb-2"/>
							<ul class="pl-3">
								<li>Berlatar warna merah</li>
								<li>Foto harus memiliki rasio 3:4</li>
								<li>Tidak berkacamata</li>
								<li>Kerudung/jilbab putih dan berseragam/kemeja warna putih (bukan kaos)</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer border-0 pt-0">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>