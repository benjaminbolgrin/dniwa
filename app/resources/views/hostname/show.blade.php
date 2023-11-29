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
	@include('hostname.partials.show-a-records')
@endif

@if (isset($dnsMX))
	@include('hostname.partials.show-mx-records')
@endif

@if (isset($httpData))
	@include('hostname.partials.show-http-data')
@endif

@if (isset($htmlData))
	@include('hostname.partials.show-html-meta-data')	
@endif
</x-app-layout>
