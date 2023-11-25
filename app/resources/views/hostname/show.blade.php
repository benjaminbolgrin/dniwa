@section('pagetitle', 'Domain information for '.$domainName.' - DNIWA')
<x-app-layout>
	<x-slot name="header">
		<h2 class="m-1">
			{{ __('Domain information') }}
		<h2>
		<hr class="mt-0"></hr>
	</x-slot>
	<div class="d-flex justify-content-center">
		<h3 class="m-4">
			{{$domainName}}
		</h3>
	</div>
	@if (isset($dnsA))
		<table class="table table-striped text-center mt-5">
			<thead>
				<tr>
					<th colspan="2" scope="col">
						{{ __('A records') }}
					</th>
				</tr>
			</thead>
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
	@if (isset($dnsMX))
		<table class="table table-striped text-center mt-5">
			<thead>
				<tr>
					<th scope="col">
						{{ __('MX records') }}
					</th>
				</tr>
			</thead>
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
	@if (isset($httpData))
		<table class="table table-striped text-center mt-5">
			<thead>
				<tr>
					<th colspan="2" scope="col">
						{{ __('Http data') }}
					</th>
				</tr>
			</thead>
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
	@if (isset($htmlData))
		@include('hostname.partials.show-html-meta-data')	
	@endif
</x-app-layout>
