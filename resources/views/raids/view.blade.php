@extends('layouts.app')

@section('content')
<h1>Raid: {{ $raid->zone->name }}</h1>
<h2>Date: {{ $raid->date }}</h2>
@include('raids.fights._createModal')

<div class="row">
    <div class="col-xs-12 col-sm-8">
        Fights @if ($raid->locked == 0) <button data-toggle="modal" data-target="#createRaidFightModal" class="btn btn-sm btn-primary pull-right">Create Fight</button> @endif
        @include('raids.fights._list')
    </div>
    <div class="col-xs-12 col-sm-4">
        Attendees @if ($raid->locked == 0) <button data-toggle="modal" data-target="#createRaidAttendeeModal" class="btn btn-sm btn-success pull-right">Add Attendee</button> @endif
    </div>
</div>
@endsection
