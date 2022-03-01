<div class="sidebar">
	<nav class="sidebar-nav">
		<ul class="nav">
			@foreach(config('admission.admin.menus') as $menu)
				@php
					$__user = auth()->user();
					$permissions = collect($menu['items'])->pluck('permissions')->filter();
					$droppermissions = collect($menu['items'])->pluck('dropdown')->flatten(1)->pluck('permissions')->filter();
				@endphp
				@if($__user->admissionCommitteeHasPermissions(array_merge($permissions->toArray(), $droppermissions->toArray())) || in_array(1, array_merge($permissions->toArray(), $droppermissions->toArray())))
					@isset($menu['title'])
						<li class="nav-title">{{ $menu['title'] }}</li>
					@endisset
					@foreach($menu['items'] as $item)
						@if(empty($item['permissions']) || $__user->admissionCommitteeHasPermissions($item['permissions']) || $item['permissions'] == 1)
							@isset($item['dropdown'])
								@if($__user->admissionCommitteeHasPermissions(collect($item['dropdown'])->pluck('permissions')) || in_array(1, collect($item['dropdown'])->pluck('permissions')->toArray()))
									<li class="nav-item nav-dropdown">
										<a class="nav-link nav-dropdown-toggle" href="{{ isset($item['route']) ? route($item['route'], ($item['params'] ?? [])) : 'javascript:;' }}"> <i class="nav-icon mdi mdi-{{ $item['icon'] }}"></i>{{ $item['label'] }}</a> 
										<ul class="nav-dropdown-items">
										@foreach($item['dropdown'] as $drop)
											@if(empty($drop['permissions']) || $__user->admissionCommitteeHasPermissions($drop['permissions']) || $drop['permissions'] == 1)
												<li class="nav-item"> <a class="nav-link {{ empty($drop['route']) ? 'disabled' : '' }}" href="{{ isset($drop['route']) ? route($drop['route'], ($drop['params'] ?? [])) : 'javascript:;' }}"> <i class="nav-icon mdi mdi-{{ $drop['icon'] }}"></i> {{ $drop['label'] }}</a> </li>
											@endif
										@endforeach
										</ul>
									</li>
								@endif
							@else
								<li class="nav-item"> <a class="nav-link" href="{{ isset($item['route']) ? route($item['route'], ($item['params'] ?? [])) : 'javascript:;' }}"> <i class="nav-icon mdi mdi-{{ $item['icon'] }}"></i> {{ $item['label'] }} </a> </li>
							@endisset
						@endif
					@endforeach
				@endif
			@endforeach
			<li class="nav-title"> AKUN </li>
			<li class="nav-item"> <a class="nav-link" href="{{ route('account.user.password', ['next' => url()->current()]) }}"> <i class="nav-icon mdi mdi-lock"></i> Ubah sandi </a> </li>
			<li class="nav-item"> <a class="nav-link" href="javascript:;" onclick="if (confirm('Apakah Anda yakin?')) document.getElementById('logout-form').submit()"> <i class="nav-icon mdi mdi-logout"></i> Logout </a> </li>
		</ul>
	</nav>
	<button class="sidebar-minimizer brand-minimizer" type="button"></button> 
</div>