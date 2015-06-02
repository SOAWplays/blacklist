<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	@if(Auth::check())
    	<meta name="X-CSRF-Token" content="{{ csrf_token() }}">
    	@endif
	    <title>{{ Blacklist::title() }}</title>
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/jumbotron.css') }}
		@yield('header_scripts')
	</head>
	@if (Route::currentRouteName() == 'users')
    <body ng-app="userApp">
	@elseif (Route::currentRouteName() == 'plugins') 
    <body ng-app="pluginApp" ng-controller="pluginManager">
	@else 
	<body>
	@endif
	    <div class="container">
            <div class="header clearfix">
                <nav>
                <ul class="nav nav-pills pull-right">
                    <li role="presentation" @if(Route::currentRouteName() == 'home')class="active"@endif><a href="{{ URL::route('home') }}">Home</a></li>
                    <li role="presentation" @if(Route::currentRouteName() == 'users')class="active"@endif><a href="{{ URL::route('users') }}">Users</a></li>
                    <li role="presentation" @if(Route::currentRouteName() == 'plugins')class="active"@endif><a href="{{ URL::route('plugins') }}">Plugins</a></li>
                    <li role="presentation"><a href="#">Login</a></li>
                </ul>
                </nav>
                <h3 class="text-muted">The Blacklist</h3>
            </div>
            @yield('content')
            <footer class="footer">
                <p class="text-muted">Copyright &copy; {{ HTML::link('http://spongybacon.com', 'SpongyBacon') }} and {{ HTML::link('http://smirking.ninja', 'SmirkingNinja') }} {{ date("Y") }}</p>
            </footer>
        </div>
        @yield('body_scripts')
	</body>
</html>
