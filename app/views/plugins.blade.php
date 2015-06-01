@extends('template')

@section('header_scripts') 
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js') }}
{{ HTML::script('js/plugins.js') }}
@stop

@section('content')
<h2>Plugins</h2>
<p class="text-muted">There <% plugins.length == 1 ? 'is' : 'are' %> <strong><% total %></strong> <% plugins.length == 1 ? 'plugin' : 'plugins' %> stored in our database!</p>

<table class="table table-bordered table-striped">
    <tr>
        <th>Plugin</th>
        <th>Status</th>
        <th>Violations</th>
    </tr>
    <tr ng-repeat="plugin in plugins">
        <td><a ng-href="<% plugin.url %>"><% plugin.name %></a></td>
        <td><% plugin.active ? 'Active' : 'Deleted' %></td>
        <td>
            <ul>
               <li ng-repeat="reason in plugin.reasons"><% reason %></li> 
            </ul>
        </td>
    </tr>
</table>
@stop