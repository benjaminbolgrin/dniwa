@section('pagetitle', 'Domain information for '.$domainName.' - DNIWA')
<x-app-layout>
	<x-slot name="header">
		<h2 class="m-1">
			{{ __('Domain information') }}
		<h2>
		<hr class="mt-0"></hr>
	</x-slot>
	<div class="d-flex justify-content-center">
		<h3 class="mb-4">
			{{$domainName}}
		</h3>
	</div>
	@if (isset($dnsA))
		<table class="table text-center mt-5">
			<thead>
				<tr>
					<th scope="col">
						{{ __('A records') }}
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($dnsA as $record)
				<tr>
					<td>
						{{$record->content}}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	@endif
	@if (isset($dnsMX))
		<table class="table text-center mt-5">
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
</x-app-layout>
