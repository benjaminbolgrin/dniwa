<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="/static/bootstrap-5.3.2-dist/css/bootstrap.css">
		<script type="text/javascript" src="/static/bootstrap-5.3.2-dist/js/bootstrap.js"></script> 
		@vite('resources/js/app.js')
	</head>
	<body class="bg-light-subtle">

		@inertia

	</body>
</html>
