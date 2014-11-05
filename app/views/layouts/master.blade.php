<!doctype html>
<html lang="en">
        <head>
        	<meta charset="UTF-8">
        	<title>Laravel PHP Framework</title>

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

                <!-- Custom CSS -->
                {{ HTML::style('css/style.css?7') }}

                @yield('head')
        </head>
        <body>

        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">WebCBT</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                        </ul>
                </div><!--/.nav-collapse -->
                </div>
        </nav>

                <div class="page">

                        <div class="page-title">
                                <h3>@yield('page-title')</h3>
                        </div>

                        <div class="flash-message">
                                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                        @if(Session::has('alert-' . $msg))
                                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                                        @endif
                                @endforeach
                        </div>

                        <div class="page-content">
                                @yield('content')
                        </div>
                </div>
        </body>
</html>
