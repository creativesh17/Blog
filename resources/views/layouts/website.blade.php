<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title') - {{ config('app.name', 'Blog') }}</title>


	<!-- Font -->

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">


	<!-- Stylesheets -->
	<style>
		.favorite_posts{ color: blue; }
	</style>
	<link href="{{asset('contents/website')}}/plugins/toastr.min.css" rel="stylesheet">
	<link href="{{asset('contents/website')}}/common-css/bootstrap.css" rel="stylesheet">
	<link href="{{asset('contents/website')}}/common-css/swiper.css" rel="stylesheet">
	<link href="{{asset('contents/website')}}/common-css/ionicons.css" rel="stylesheet">
	<link href="{{asset('contents/website')}}/common-css/style.css" rel="stylesheet">
	@stack('css')

</head>
<body >

	@include('website.header')

	@yield('content');

	@include('website.footer')


	<!-- SCIPTS -->

	<script src="{{asset('contents/website')}}/common-js/jquery-3.1.1.min.js"></script>
	<script src="{{asset('contents/website')}}/common-js/tether.min.js"></script>
	<script src="{{asset('contents/website')}}/common-js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.19.1/sweetalert2.min.js"></script>
	<script src="{{asset('contents/website')}}/plugins/toastr.min.js"></script>
	{{-- <script src="{{asset('contents/website')}}/plugins/toastr.js"></script> --}}

	
	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible alertsuccess" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Success! </strong> Category has been added successfully. 
		</div>
	@endif
	@if(Session::has('error'))
		<div class="alert alert-danger alert-dismissible alerterror" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Error!</strong> An error occurred;
		</div>
	@endif
	@stack('js')
	<script src="{{asset('contents/website')}}/common-js/swiper.js"></script>
	<script src="{{asset('contents/website')}}/common-js/scripts.js"></script>
	<script src="{{asset('contents/website')}}/common-js/customwebsite.js"></script>
	

	@if(Session::has('success'))
		<script>
			toastr.success("{{ Session::get('success') }}", "Success", {
				closeButton: true,
				progressbar: true,
			});
		</script>
	@endif
	@if(Session::has('info'))
		<script>
			toastr.info("{{ Session::get('info') }}");
		</script>
	@endif
	@if(Session::has('warning'))
		<script>
			toastr.warning("{{ Session::get('warning') }}");
		</script>
	@endif
	@if(Session::has('error'))
		<script>
			toastr.error("{{ Session::get('error') }}");
		</script>
	@endif
</body>
</html>
