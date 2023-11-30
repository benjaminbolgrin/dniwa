<table class="table table-striped mt-5">
	<thead>
		<tr class="text-center">
			<th colspan="4" scope="col">
				Meta tags
@if (count($htmlData) !=0)
	@php
		$currentServerTime =  date('Y-m-d H:i:s');
		$dateTimeMeta = strtotime($htmlData[0]->updated_at);
		$dateTimeCurrent = strtotime($currentServerTime);
		$timeDifferenceMeta = floor(($dateTimeCurrent - $dateTimeMeta) / 60);
	@endphp
				<br />
				<span class="text text-muted">
	@if ($timeDifferenceMeta > 0)
					{{ __('updated '.$timeDifferenceMeta.' minutes ago') }}
	@else
					{{ __('updated recently') }}
	@endif
				</span>
@endif
			</th>
		</tr>
@if (count($htmlData) == 0)
		</thead>
		<tbody>
			<tr>
				<td class="text-center" colspan="4">
					{{ __('There are no meta tag records for the given domain.') }}
				</td>
			</tr>
		</tbody>
	</table>

@else
		<tr>
			<th class="text-end w-25 pe-3 text-end" scope="col">
				{{ __('Meta attribute')}}
			</th>
			<th class="text-start w-25 ps-3 text-start" scope="col">
				{{ __('Attribute value') }}
			</th>
			<th class="text-start w-25 ps-3 text-end" scope="col">
				{{ __('Meta attribute') }}
			</th>
			<th class="text-start w-25 ps-3 text-start" scope="col">
				{{ __('Attribute value') }}
			</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($htmlData as $metaData)
		<tr>
			<td class="text-end w-25 pe-3">
			@if ($metaData['meta_name'] != '')
				{{ __('name') }}
			@endif
			@if ($metaData['meta_property'] != '')
				{{ __('property') }}
			@endif
			@if ($metaData['meta_charset'] != '')
				{{ __('charset') }}
			@endif
			@if ($metaData['meta_http_equiv'] != '')
				{{ __('http-equiv') }}
			@endif
			@if ($metaData['meta_itemprop'] != '')
				{{ __('itemprop') }}
			@endif

			</td>
			<td class="text-start w-25 ps-3">
			@if ($metaData['meta_name'] != '')
				{{ $metaData['meta_name'] }}
			@endif
			@if ($metaData['meta_property'] != '')
				{{ $metaData['meta_property'] }}
			@endif
			@if ($metaData['meta_charset'] != '')
				{{ $metaData['meta_charset'] }}
			@endif
			@if ($metaData['meta_http_equiv'] != '')
				{{ $metaData['meta_http_equiv'] }}
			@endif
			@if ($metaData['meta_itemprop'] != '')
				{{ $metaData['meta_itemprop'] }}
			@endif
			</td>
			<td class="text-end w-25 pe-3">
			@if ($metaData['meta_content'] != '')
				{{ __('content') }}
			@endif
			</td>
			<td class="text-start w-25 ps-3">
			@if ($metaData['meta_content'] != '')
				{{ __($metaData['meta_content']) }}
			@endif

			</td>
		</tr>
	@endforeach
	</tbody>	
</table>
@endif
