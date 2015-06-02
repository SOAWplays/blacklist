@extends('template')

@section('header_scripts')
{{ HTML::style('css/login.css') }}

{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js') }}
{{ HTML::script('js/auth/login.js') }}
@stop

@section('content')
<div id="app" ng-app="loginApp" ng-controller="loginManager">
    <div ng-show="alert.visible" class="alert alert-<% alert.style %>" ng-bind-html="alert.content | safe"></div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 text-center login">
            <form ng-submit="submit('{{ csrf_token() }}')">
                <h2>Login</h2>
                <label class="sr-only">Email</label>
                <input type="email" name="email" class="form-control" placeholder="bob@changeme.org" ng-model="auth.email">
                <label class="sr-only">Password</label>
                <input type="password" name="password" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" ng-model="auth.password">
                <button type="submit" class="btn btn-success btn-block">Login</button>
            </form>
        </div>
    </div>
</div>
@stop

@section('scripts')
{{ HTML::script('js/bootstrap.min.js') }}
@stop