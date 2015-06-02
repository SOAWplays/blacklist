@extends('template')

@section('header_scripts') 
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js') }}
{{ HTML::script('js/plugins.js') }}
@stop

@section('content')
<div class="alert alert-danger" ng-show="nextPageEmpty">
    <strong>Sorry!</strong> invalid page number provided!
</div>

<h2>Plugins</h2>
<p class="text-muted">There <% total == 1 ? 'is' : 'are' %> <strong plugin-counter><% total %></strong> <% total == 1 ? 'plugin' : 'plugins' %> stored in our database!</p>
<table class="table table-bordered table-striped">
    <tr>
        <th>Plugin</th>
        <th>Status</th>
        <th>Violations</th>
    </tr>
    <tr ng-repeat="plugin in plugins" class="plugin" data-id="<% plugin.id %>">
        <td><a ng-href="<% plugin.url %>"><% plugin.name %></a></td>
        <td><% plugin.active == true ? 'Active' : 'Deleted' %></td>
        <td>
            <ul>
               <li ng-repeat="reason in plugin.reasons"><% reason %></li> 
            </ul>
        </td>
    </tr>
</table>
<nav class="text-center">
    <ul class="pagination">
        <li ng-class="(page - 1 == 0) ? 'disabled' : ''" ng-click="page - 1 == 0 || goto(page - 1)">
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li ng-repeat="pageNumber in pages" ng-class="page == pageNumber ? 'active' : ''"><a ng-href="#" ng-click="goto(pageNumber)"><% pageNumber %></a></li>
        <li ng-class="(page >= pages.length) ? 'disabled' : ''" ng-click="(page >= pages.length) || goto(page + 1)">
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
@stop