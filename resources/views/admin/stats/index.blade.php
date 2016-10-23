@extends('layouts.admin')

@section('content')

    <section>
        <h1>Character Stats</h1>

        @if (isset($stats) && count($stats) > 0)
            <table class="table">
            <thead>
                <tr>
                    <th>Raid</th>
                    <th>Fight</th>
                    <th>Character</th>
                    <th>Metric</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($stats as $s)
                <tr>
                    <td>{{ $s->raidfight->raid->zone->name }}</td>
                    <td>{{ $s->raidfight->boss->name }}</td>
                    <td>{{ $s->character->name }}</td>
                    <td>{{ $s->metric->name }}</td>
                    <td>{{ $s->value }}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
            </table>
            {{ $stats->links() }}
        @else
            <p>There are currently no stats recorded.</p>
        @endif
    </section>
@stop