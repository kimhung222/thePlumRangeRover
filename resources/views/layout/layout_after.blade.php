<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cánh cụt shop</title>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/custom.css') }}"/>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/login.css') }}"/>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.min.css') }}"/>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css')}}"/>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/new_css.css')}}"/>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/new1_css.css')}}"/>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/tool-tip.css')}}"/>
	<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
	<link href="https://fonts.googleapis.com/css?family=Sriracha" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
	<style>

	</style>
</head>
<body>
	@include('partials.navbar2')
	<div class="space-1"></div>
	<div id="jump"></div>
	<div class="space-2"></div>
	@yield('body.content')
		<a href="#jump" class="btn btn-primary btn-circle btn-lg"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
	@include('partials.footer')
	<script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/custom.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/livesearch.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/livesearch-index.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/suggest.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/test.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/tool-tip.js')}}"></script> 
</body>
</html>