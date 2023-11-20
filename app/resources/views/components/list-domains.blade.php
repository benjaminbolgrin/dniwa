<div class="d-flex p-4 justify-content-center">
	<h3>
		Domain list
	</h3>
</div>
@if (isset($domains))
	<div class="list-group text-center">
		@foreach ($domains as $domain)
			<a href=/hostname/{{ $domain['id'] }} class="list-group-item list-group-item-action">
				{{ $domain['name'] }}
			</a>
		@endforeach
	</div>
@endif
