@extends('layouts/admin')

@section('content')
<table class="table">
<thead>
<tr><th>Username</th></tr>
</thead>
<tbody>
@foreach($users as $user)
<tr><td>{{ $user->name }}</td></tr>
@endforeach
</tbody>
</table>

@stop