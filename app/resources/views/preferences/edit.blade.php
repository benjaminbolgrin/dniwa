@section('pagetitle', 'Preferences - DNIWA')
<x-app-layout>
    <x-slot name="header">
        <h2 class="m-1">
            {{ __('Preferences') }}
        <h2>
	<hr class="mt-0"></hr>
    </x-slot>

    @include('preferences.partials.update-theme-form')

</x-app-layout>
