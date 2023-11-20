<div class="d-flex pt-4 pb-4">
	<h3>
		Domain list
	</h3>
</div>
@if (isset($domains))
	@foreach ($domains as $domain)
	<form method="post" action="{{ route('dashboard.delete', ['domain' => $domain['id']]) }}" id="form-domain-delete" class="mb-2">
		@csrf
		@method('delete')
		<div class="btn-group d-flex w-100">
			<a href=/hostname/{{ $domain['id'] }} class="btn btn-outline-primary w-75">
				{{ $domain['name'] }}
			</a>
			<button type="submit" class="btn btn-outline-danger w-25">
				{{ __('Delete') }}
			</button>
		</div>
	</form>
	@endforeach
@endif
