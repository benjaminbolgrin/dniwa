<table class="table table-striped text-center mt-5">
	<thead>
		<tr>
			<th colspan="2" scope="col">
				{{ __('A records') }}
			</th>
		</tr>
	</thead>
@if (count($dnsA) == 0)
	<tbody>
		<tr>
			<td class="text-center" colspan="2">
				{{ __('There are no A records for the given domain.') }}
			</td>
		</tr>
	</tbody>
@else
	<tbody>
		@foreach ($dnsA as $record)
		<tr>
			<td class="w-50 pe-3 text-end">
				{{$record->hostname}}
			</td>
			<td class="ps-3 text-start">
				{{$record->content}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif
