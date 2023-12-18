<!DOCTYPE html>
@auth
	@if (!is_null($userPreferences))
		<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{$userPreferences->theme}}">
	@else
		<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
	@endif
@endauth
@guest
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
@endguest
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="/static/bootstrap-5.3.2-dist/css/bootstrap.css">
		<script type="text/javascript" src="/static/bootstrap-5.3.2-dist/js/bootstrap.js"></script> 
		@vite('resources/js/app.js')
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

		@inertia

	</body>
</html>
