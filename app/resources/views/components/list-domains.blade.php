<div class="d-flex p-4 justify-content-center">
	<h3>
		Domain list
	</h3>
</div>
<div class="d-flex justify-content-center flex-wrap wrap">
	@foreach ($domains as $domain)
		<span class="p-2">
			<a href=/hostname/{{ $domain['id'] }}>{{ $domain['name'] }}</a>
		</span>
	@endforeach
</div>

