<form id="logout-form" class="form-confirm form-block d-inline" action="{{ route('account.logout', ['next' => $next ?? url()->current()]) }}" method="POST"> @csrf {{ $slot ?? '' }} </form>