@extends('layouts.app')

@section('content')
    <h1>Progression</h1>

    @if (isset($progression))
        @foreach($progression as $raid => $bosses)
            <h2>{{ $raid }}</h2>
            <table class="table">
                <thead>
                    <tr><th colspan="4">{{ $raid }}</th></tr>
                    <tr>
                        <th>Boss</th>
                        <th>N</th>
                        <th>HC</th>
                        <th>M</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bosses as $boss => $kills)
                        <tr>
                            <td style="width: 50%;">{{ $boss }}</td>
                            <?php
                                $difficulties = ['n', 'h', 'm'];
                            ?>
                            @foreach($difficulties as $diff)
                                @if ($kills[$diff])
                                    <td class="killed">@if ($kills['n']) Killed @endif</td>
                                @else
                                    <td>-</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
@endsection