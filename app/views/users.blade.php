@extends('template')

@section('content')
<h2>Users</h2>
<p>Here you can see a bunch of really mean people!</p>
<br />

<table class="table table-bordered table-striped">
    <tr>
        <th>Profiles</th>
        <th>Reasons</th>
    </tr>
    <tr>
        <td>
            <ul class="profiles">
                <li><span class="label label-primary">Spigot</span> <a href="#">RickBob</a></li>
                <li><span class="label label-primary">MC-Market</span> <a href="#">Rick</a></li>
            </ul>
        </td>
        <td>
            <ul>
                <li>Killed someone</li>
                <li>Killed another person</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <ul class="profiles">
                <li><span class="label label-primary">Spigot</span> <a href="#">RickBob</a></li>
                <li><span class="label label-primary">MC-Market</span> <a href="#">Rick</a></li>
            </ul>
        </td>
        <td>
            <ul>
                <li>Killed someone</li>
                <li>Killed another person</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <ul class="profiles">
                <li><span class="label label-primary">Spigot</span> <a href="#">RickBob</a></li>
                <li><span class="label label-primary">MC-Market</span> <a href="#">Rick</a></li>
            </ul>
        </td>
        <td>
            <ul>
                <li>Killed someone</li>
                <li>Killed another person</li>
            </ul>
        </td>
    </tr>
</table>

@stop