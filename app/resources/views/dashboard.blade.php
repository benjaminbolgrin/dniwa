@section('pagetitle', 'Dashboard - DNIWA')
<x-app-layout>
	<x-slot name="header">
		<div class="d-flex align-content-end">
			<div>
				<h2 class="m-1">
					{{ __('Dashboard') }}
				</h2>
			</div>
			<div class="align-self-end p-1" style="margin-left:auto;">
				<span class="text text-primary">
					<a href="{{ route('hostname.add') }}">
						{{ __('Add domain') }}
					</a>
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-secondary">
					&#124;
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-primary">
					<a href="{{ route('preferences.edit')}}">{{__('Preferences')}}</a>
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-secondary">
					&#124;
				</span>
			</div>
			<div class="align-self-end p-1">
				<span class="text text-primary">
					<a href="{{ route('profile.edit')}}">{{__('Account')}}</a> 
				</span>
			</div>
		</div>
		<hr class="mt-0"/>
	</x-slot>
	@if (session('status') === 'domain-deleted')
		<div class="alert alert-info" role="alert">
			{{ __('Domain \''.session('deletedDomain').'\' has been deleted from your list!') }}
		</div>
	@endif
	<x-list-domains :domains="$domains"/>
</x-app-layout>
