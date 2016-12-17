@extends('layouts/admin')

@section('content')

<table class="table">
<thead>
<tr>
    <th>Raider</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
@foreach($raiders as $raider)
<?php $class_name = $raider->cssClass($raider->class_id); ?>
<tr class="{{ $class_name }}">
    <td>{{ $raider->name }}</td>
    <td><button class="btn btn-xs btn-danger" onclick="return deleteCharacter({{ $raider->id }});">Delete</button></td>
</tr>
@endforeach
</tbody>
</table>

@stop