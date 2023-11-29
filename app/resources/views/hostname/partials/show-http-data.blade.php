<table class="table table-striped text-center mt-5">
	<thead>
		<tr>
			<th colspan="2" scope="col">
				{{ __('Http data') }}
			</th>
		</tr>
	</thead>
@if ($httpData->response_code == '')
	<tbody>
		<tr>
			<td class="text-center" colspan="2">
				{{ __('There is no http data for the given domain.')}}
			</td>
		</tr>
	</tbody>
</table>
@else
	<tbody>
		<tr>
			<th scope="row" class="w-50 pe-3 text-end">
				{{ __('Response code: ') }}
			</td>
			<td class="text-right ps-3 text-start">
				{{ $httpData->response_code }}
			</td>
		</tr>
		<tr>
			<th scope="row" class="w-50 pe-3 text-end">
				{{ __('Content-Type: ') }}
			</td>
			<td class="ps-3 text-start">
				{{ $httpData->header }}
			</td>
		</tr>
		<tr>
			<th scope="row" class="w-50 pe-3 text-end">
				{{ __('Title: ') }}
			</td>
			<td class="ps-3 text-start">
				{{ $httpData->title }}
			</td>
		</tr>
		
	</tbody>
</table>
@endif
