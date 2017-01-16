<!DOCTYPE html>
<html lang="en">
<head>
	<title>ALttP VT Randomizer</title>
	<meta name="keywords" content="ALttP, Randomizer, patcher">
	<meta name="description" content="ALttP Web VT Randomizer">
	<meta charset="utf-8" />

	<link rel="stylesheet" href="{{ elixir('css/app.css') }}">

	<script src="{{ elixir('js/app.js') }}"></script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="/">ALttP VT Randomizer</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
		  <ul class="nav navbar-nav navbar-right">
			<li{!! (request()->path() == 'stuck') ? ' class="active"' : '' !!}><a href="/stuck">Stuck?</a></li>
		  	<li><a href="https://github.com/sporchia/alttp_vt_randomizer/issues/new" target="_blank">Report Issue</a></li>
			<li{!! (request()->path() == 'about') ? ' class="active"' : '' !!}><a href="/about">About</a></li>
			@if (Auth::check())
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li><a href="/auth/logout">Logout</a></li>
			  </ul>
			</li>
			@else
			<!-- <li{!! (request()->path() == 'about') ? ' class="active"' : '' !!}><a href="/auth/login">Login</a></li> -->
			@endif
		  </ul>
		</div>
	  </div>
	</nav>

	<div class="container">
	@yield('content')
	</div>
	<script src="{{ elixir('js/all.js') }}"></script>
</body>
</html>
