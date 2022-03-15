<div class="card">
	<div class="card-body">
		<h5 class="mb-4">Link cepat</h5>
		<ul class="pl-3 mb-0">
			<li><a href="{{ route('admission.home') }}">Beranda</a></li>
			<li><a href="{{ route('admission.form.profile', ['next' => route('admission.home')]) }}">Isi data diri</a></li>
			<li><a href="{{ route('admission.form.email', ['next' => route('admission.home')]) }}">Isi alamat e-mail</a></li>
			<li><a href="{{ route('admission.form.phone', ['next' => route('admission.home')]) }}">Isi nomor HP</a></li>
			<li><a href="{{ route('admission.form.address', ['next' => route('admission.home')]) }}">Isi alamat asal</a></li>
			<li><a href="{{ route('admission.form.parent', ['type' => 'father', 'next' => route('admission.home')]) }}">Isi data ayah</a></li>
			<li><a href="{{ route('admission.form.parent', ['type' => 'mother', 'next' => route('admission.home')]) }}">Isi data ibu</a></li>
			{{-- <li><a href="{{ route('admission.form.parent', ['type' => 'foster', 'next' => route('admission.home')]) }}">Isi data wali</a></li> --}}
			{{-- <li><a href="{{ route('admission.form.studies.index') }}">Isi riwayat pendidikan</a></li>
			<li><a href="{{ route('admission.form.organizations.index') }}">Isi riwayat organisasi</a></li>
			<li><a href="{{ route('admission.form.achievements.index') }}">Isi data prestasi</a></li> --}}
			<li><a href="{{ route('admission.form.major') }}">Pemilihan program studi</a></li>
			<li><a href="{{ route('admission.form.file') }}">Berkas pendaftaran</a></li>
			{{-- <li><a href="{{ route('admission.form.test') }}">Pemilihan tanggal tes</a></li> --}}
		</ul>
	</div>
</div>