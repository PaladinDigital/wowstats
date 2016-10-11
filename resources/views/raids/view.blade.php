@extends('layouts.app')

@section('content')
<h1>Raid: {{ $raid->zone->name }}</h1>
<h2>Date: {{ $raid->date }} @if ($raid->locked == 0) <button data-toggle="modal" data-target="#createRaidFightModal" class="btn btn-primary pull-right">Create Fight</button> @endif</h2>
@include('raids.fights._createModal')

<div class="row">
    <div class="col-xs-12 col-sm-8">
        Fights
        @include('raids.fights._list')
    </div>
    <div class="col-xs-12 col-sm-4">
        Characters
    </div>
</div>
@endsection
