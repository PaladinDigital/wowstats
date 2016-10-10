@extends('layouts.app')

@section('content')
    <h1>Raids <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#createRaidModal">Create Raid</button></h1>
    @include('raids._createModal')

    @if (count($raids) > 0)
        <table class="table table-striped">
        <thead>
            <tr><th>Raid</th><th>Date / Time</th></tr>
        </thead>
        <tbody>
        @foreach($raids as $raid)
            <tr><td><a href="{{ route('raid.view', $raid->id) }}">{{ $raid->zone->name }}</a></td><td>{{ $raid->date }}</td></tr>
        @endforeach
        </tbody>
        </table>
    @else
        <p>No raids have been recorded yet.</p>
    @endif
@endsection
