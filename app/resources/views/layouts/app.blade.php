<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('pagetitle', config('app.name'))</title>
		<x-bootstrap/>
	</head>
	<body class="bg-light-subtle">
		<x-dniwa-navbar/>
		<div class="container-md">
			<!-- Page Heading -->
			@if (isset($header))
			<header>
				<div>
					{{ $header }}
				</div>
			</header>
			@endif
			<!-- Page Content -->
			<main>
				{{ $slot }}
			</main>
		</div>
	</body>
</html>
