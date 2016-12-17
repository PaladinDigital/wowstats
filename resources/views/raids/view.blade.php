@extends('layouts.app')

@section('content')
<h1>Raid: {{ $raid->zone->name }} ({{ $raid->difficulty() }})</h1>
<h2>Date: {{ $raid->date }}</h2>
@if ($user->can('administrate'))
@include('raids.fights._createModal')
@include('raids.attendees._addAttendeeModel')
@endif

<div class="row">
    <div class="col-xs-12 col-sm-8">
        <h3>Fights @if ($raid->locked == 0 && $user->can('administrate')) <button data-toggle="modal" data-target="#createRaidFightModal" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Create Fight</button> @endif</h3>
        @include('raids.fights._list')
    </div>
    <div class="col-xs-12 col-sm-4">
        <h3>Attendees @if ($raid->locked == 0 && $user->can('administrate')) <button data-toggle="modal" data-target="#addAttendeeModal" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> Add Attendee</button> @endif</h3>
        @include('raids.attendees._list')
    </div>
</div>
@endsection
