<div class="d-flex pt-4 pb-4">
	<h3>
		Domain list
	</h3>
</div>
@if (isset($domains))
	@foreach ($domains as $domain)
		<div class="btn-group d-flex mb-2" role="group">
			<div class="btn-group w-100" role="group">
				<a href=/hostname/{{ $domain['id'] }} class="btn btn-outline-primary w-75">
					{{ $domain['name'] }}
				</a>
				<button type="submit" class="btn btn-outline-danger w-25">
					{{ __('Delete') }}
				</button>
			</div>
		</div>
	@endforeach
@endif
