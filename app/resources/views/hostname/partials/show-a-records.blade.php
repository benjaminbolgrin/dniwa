<table class="table table-striped text-center mt-5">
	<thead>
		<tr>
			<th colspan="2" scope="col">
				{{ __('A records') }}
@if (count($dnsA) !=0)
	@php
		$currentServerTime =  date('Y-m-d H:i:s');
		$dateTimeA = strtotime($dnsA[0]->updated_at);
		$dateTimeCurrent = strtotime($currentServerTime);
		$timeDifferenceA = floor(($dateTimeCurrent - $dateTimeA) / 60);
	@endphp
				<br />
				<span class="text text-muted">
	@if ($timeDifferenceA > 0)
					{{ __('updated '.$timeDifferenceA.' minutes ago') }}
	@else
					{{ __('updated recently') }}
	@endif
				</span>
@endif
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
