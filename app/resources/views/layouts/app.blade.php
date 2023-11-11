<!DOCTYPE html>
@auth
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{$userPreferences->theme}}">
@endauth
@guest
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
@endguest
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('pagetitle', config('app.name'))</title>
		<x-bootstrap/>
		@guest
		<script>
			var localTheme = localStorage.getItem("theme");
					
			if(localTheme != null && (localTheme == "dark" || localTheme == "light")){
				document.querySelector("html").setAttribute("data-bs-theme", localTheme);
			}
		</script>
		@endguest
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
