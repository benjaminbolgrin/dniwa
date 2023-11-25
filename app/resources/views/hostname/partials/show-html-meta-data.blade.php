<table class="table table-striped mt-5">
	<thead>
		<tr class="text-center">
			<th colspan="4" scope="col">
				Meta tags
			</th>
		</tr>
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
