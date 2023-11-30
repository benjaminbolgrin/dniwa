<table class="table table-striped text-center mt-5">
	<thead>
		<tr>
			<th scope="col">
				{{ __('MX records') }}
@if (count($dnsMX) !=0)
	@php
		$currentServerTime =  date('Y-m-d H:i:s');
		$dateTimeMX = strtotime($dnsMX[0]->updated_at);
		$dateTimeCurrent = strtotime($currentServerTime);
		$timeDifferenceMX = floor(($dateTimeCurrent - $dateTimeMX) / 60);
	@endphp
				<br />
				<span class="text text-muted">
	@if ($timeDifferenceMX > 0)
					{{ __('updated '.$timeDifferenceMX.' minutes ago') }}
	@else
					{{ __('updated recently') }}
	@endif
				</span>
@endif
			</th>
		</tr>
	</thead>
@if (count($dnsMX) == 0)
	<tbody>
		<tr>
			<td class="text-center">
				{{ __('There are no MX records for the given domain.') }}
			</td>
		</tr>
	</tbody>
</table>
@else
	<tbody>
		@foreach ($dnsMX as $record)
		<tr>
			<td>
				{{$record->content}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif
