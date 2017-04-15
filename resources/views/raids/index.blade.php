@extends('layouts.app')

@section('content')
    <h1>Raids <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#createRaidModal"><i class="fa fa-plus"></i> Create Raid</button></h1>
    @include('raids._createModal')

    @if (count($raids) > 0)
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Raid</th>
                <th>Fights</th>
                <th>Kills</th>
                <th>Date / Time</th>
            </tr>
        </thead>
        <tbody>
        @foreach($raids as $raid)
            <?php
                $kills = $raid->getBossKillCount();
                if ($kills > 0) {
                    $tr_class = 'killed';
                } else {
                    $tr_class = 'progression';
                }
            ?>
            <tr class="{{ $tr_class }}">
                <td><a href="{{ route('raid.view', $raid->id) }}">{{ $raid->zone->name }}</a> ({{ $raid->difficulty() }})</td>
                <td>{{ $raid->getFightCount() }}</td>
                <td>{{ $raid->getBossKillCount() }}</td>
                <td>{{ $raid->date }}</td>
            </tr>
        @endforeach
        </tbody>
        </table>

        {{ $raids->render() }}
    @else
        <p>No raids have been recorded yet.</p>
    @endif
@endsection
