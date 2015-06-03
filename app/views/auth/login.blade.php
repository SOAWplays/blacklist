@extends('template')

@section('header_scripts')
{{ HTML::style('css/login.css') }}

{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js') }}
{{ HTML::script('js/auth/angular-recaptcha.min.js') }}
{{ HTML::script('js/auth/auth.js') }}
@stop

@section('content')
<div id="app" ng-app="authApp" ng-controller="authManager">
    <div ng-show="alert.visible" class="alert alert-<% alert.style %>" ng-bind-html="alert.content | safe"></div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 text-center login">
            <form ng-submit="submit('{{ csrf_token() }}')">
                <h2>Login</h2>
                <label class="sr-only">Email</label>
                <input type="email" name="email" class="form-control" placeholder="frank@change.org" ng-model="auth.email">
                <label class="sr-only">Password</label>
                <input type="password" name="password" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" ng-model="auth.password">
                <div class="btn-group btn-group-justified" role="group" aria-label="Actions">
                    <a href="{{ URL::action('AuthController@getRegister') }}" class="btn btn-success">Register</a>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('scripts')
{{ HTML::script('js/bootstrap.min.js') }}
@stop