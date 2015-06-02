@extends('template')

@section('header_scripts')
{{ HTML::style('css/login.css') }}

{{ HTML::script('https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&render=explicit', array('async' => '', 'defer' => '')) }}
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js') }}
{{ HTML::script('js/auth/angular-recaptcha.min.js') }}
{{ HTML::script('js/auth/register.js') }}
@stop

@section('content')
<div id="app" ng-app="registrationApp" ng-controller="registrationManager">
    <div ng-show="alert.visible" class="alert alert-<% alert.style %>" ng-bind-html="alert.content | safe"></div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 text-center registration">
            <form ng-submit="submit('{{ csrf_token() }}')">
                <h2>Register</h2>
                <label class="sr-only">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Frank" ng-model="auth.name">
                <label class="sr-only">Email</label>
                <input type="email" name="email" class="form-control" placeholder="you@changeme.org" ng-model="auth.email">
                <label class="sr-only">Password</label>
                <input type="password" name="password" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" ng-model="auth.password">
                <label class="sr-only">Password</label>
                <input type="password" name="confirm" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" ng-model="auth.confirm">
                <div class="fluid" vc-recaptcha key="'6LczwwcTAAAAAG7nlVweJHYX0jzL_ZJJTui_Zips'" on-success="auth.captcha = response"></div>
                <button type="submit" class="btn btn-success btn-block">Login</button>
            </form>
        </div>
    </div>
</div>
@stop

@section('scripts')
{{ HTML::script('js/bootstrap.min.js') }}
@stop