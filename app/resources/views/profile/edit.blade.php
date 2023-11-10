@section('pagetitle', 'Account settings - DNIWA')
<x-app-layout>
    <x-slot name="header">
        <h2 class="m-1">
            {{ __('Account settings') }}
        <h2>
	<hr class="mt-0"></hr>
    </x-slot>

    @include('profile.partials.update-profile-information-form')
    @include('profile.partials.update-password-form')

</x-app-layout>
