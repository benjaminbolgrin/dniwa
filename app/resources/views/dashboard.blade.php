<x-app-layout>
	<x-slot name="header">
		<h2>
			{{ __('Dashboard') }}
		</h2>
	</x-slot>
	<div class="d-flex flex-row-reverse">
		<div class="p-2">
			<span class="text text-primary">
				<a href="{{ route('preferences')}}">{{__('Preferences')}}</a>
			</span>
		</div>
		<div class="p-2">
			<span class="text text-secondary-subtle">
				|
			</span>
		</div>
		<div class="p-2">
			<span class="text text-primary">
				<a href="{{ route('profile.edit')}}">{{__('Account')}}</a> 
			</span>
			
		</div>
	</div>
	<hr class="mt-0"/>
</x-app-layout>
