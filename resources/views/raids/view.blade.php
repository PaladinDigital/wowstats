@extends('layouts.app')

@section('content')
<h1>Raid: {{ $raid->zone->name }}</h1>
<h2>Date: {{ $raid->date }}</h2>
@if ($user->can('administrate'))
@include('raids.fights._createModal')
@include('raids.attendees._createModal')
@endif

<div class="row">
    <div class="col-xs-12 col-sm-8">
        <h3>Fights @if ($raid->locked == 0 && $user->can('administrate')) <button data-toggle="modal" data-target="#createRaidFightModal" class="btn btn-sm btn-primary pull-right">Create Fight</button> @endif</h3>
        @include('raids.fights._list')
    </div>
    <div class="col-xs-12 col-sm-4">
        <h3>Attendees @if ($raid->locked == 0 && $user->can('administrate')) <button data-toggle="modal" data-target="#createRaidAttendeeModal" class="btn btn-sm btn-success pull-right">Add Attendee</button> @endif</h3>
        @include('raids.attendees._list')
    </div>
</div>
@endsection
