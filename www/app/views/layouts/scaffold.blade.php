<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
		<style>
			table form { margin-bottom: 0; }
			form ul { margin-left: 0; list-style: none; padding-left: 0;}
			.error { color: red; font-style: italic; }
			body { padding-top: 20px; }
			.top-buffer { margin-top: 30px; }
		</style>
	</head>

	<body>

		<div class="container">
			@if (Session::has('message'))
				<div class="flash alert">
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif

			@yield('main')
		</div>

	</body>

</html>