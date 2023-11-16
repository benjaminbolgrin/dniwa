@section('pagetitle', 'Add Hostname - DNIWA')
<x-app-layout>
    <x-slot name="header">
        <h2 class="m-1">
            {{ __('Add hostname') }}
        <h2>
	<hr class="mt-0"></hr>
    </x-slot>

    @include('hostname.partials.add-hostname-form')

</x-app-layout>
