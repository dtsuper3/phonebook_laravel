<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Phonebook</title>
	<link rel="stylesheet" href="{{ asset('css/app.css' )}}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel={ csrfToken: '{{ csrf_token() }}'}</script>
</head>
<body>
	<div id="app">
		<Navbar></Navbar>
		<div class="container">
			<router-view></router-view>			
		</div>		
		<Myfooter></Myfooter>
	</div>
	<script src="{{ asset('js/app.js' )}}"></script>
</body>
</html>