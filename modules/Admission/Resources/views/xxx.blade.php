<!DOCTYPE html>
<html>
<head>
	<title>xxx</title>
</head>
<body>

	<table>
		<thead>
			<tr>
				<th>NO</th>
				<th>ID</th>
				<th>ID User</th>
				<th>Username</th>
				<th>No daftar</th>
				<th>Nama</th>
			</tr>
		</thead>
		<tbody>
			@foreach($registrants as $r)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $r->id }}</td>
					<td>{{ $r->user_id }}</td>
					<td>{{ $r->user->username }}</td>
					<td>{{ $r->kd }}</td>
					<td>{{ $r->user->profile->full_name }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>