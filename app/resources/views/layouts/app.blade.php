<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('pagetitle', config('app.name'))</title>
		<x-bootstrap/>
	</head>
	<body>
		<div class="container-fluid">
			<x-dniwa-navbar/>
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
