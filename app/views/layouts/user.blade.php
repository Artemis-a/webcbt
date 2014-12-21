<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>WebCBT</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- jQuery & jQuery UI -->
        {{ HTML::style('css/jquery-ui.min.css') }}
        {{ HTML::style('css/jquery-ui.structure.min.css') }}
        {{ HTML::style('css/jquery-ui.theme.min.css') }}
        {{ HTML::script('js/jquery-1.11.1.min.js') }}
        {{ HTML::script('js/jquery-ui.min.js') }}

        <!-- jQuery Plugins -->
        {{ HTML::script('js/jquery-ui-timepicker-addon.js') }}
        {{ HTML::style('css/jquery-ui-timepicker-addon.css') }}

        <!-- Bootstrap -->
        {{ HTML::style('css/bootstrap.min.css') }}
        <!-- {{ HTML::style('css/bootstrap-theme.min.css') }} -->
        {{ HTML::script('js/bootstrap.min.js') }}

	<!-- Chart.js -->
        {{ HTML::script('js/Chart.min.js') }}

        <!-- WARNING ! This is a assignment statement ! -->
        @if ($time = rand(0, 1000)) @endif

        <!-- Custom CSS -->
        {{ HTML::style('css/sb-admin.css?' . $time) }}
        {{ HTML::style('css/style.css?' . $time) }}

        @yield('head')
</head>

<body>

<div id="wrapper">

<!-- Navigation -->
<nav class="navbar navbar-fixed-top navbar-custom" role="navigation">

	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.html">WebCBT</a>

	</div>
</nav>
<!-- /.nav -->

<div id="page-wrapper">
<div class="container-fluid">

	<!-- Page-title -->
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">@yield('page-title')</h3>
		</div>
	</div>
        <!-- /.row -->

	<!-- Alerts -->
	<div class="row">
		<div class="col-lg-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                	@if(Session::has('alert-' . $msg))
				<div class="alert alert-info alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ Session::get('alert-' . $msg) }}
				</div>
			@endif
		@endforeach
		</div>
	</div>
        <!-- /.row -->


	<!-- Content -->
	<div class="row">
		<div class="col-lg-12">
			<div class="page-content">
				@yield('content')
			</div>
		</div>
	</div>
        <!-- /.row -->

</div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->

</body>
</html>
