@extends('layouts/admin')

@section('content')
<table class="table">
<thead>
    <tr>
        <th>Username</th>
        <th>Administrator</th>
    </tr>
</thead>
<tbody>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td><?php if ($user->isAdmin()) { echo "Yes"; } ?></td>
    </tr>
    @endforeach
</tbody>
</table>

@stop