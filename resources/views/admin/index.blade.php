@extends('layouts.admin')

@section('content')

    <section>
        <h1>Dashboard</h1>
        @include('admin/widgets/_statsWidget', ['class' => '', 'stat' => 'Users', 'value' => $stats['users']])
        @include('admin/widgets/_statsWidget', ['class' => '', 'stat' => 'Raids', 'value' => $stats['raids']])
    </section>

    <section>
        <h1>Administration</h1>
        <ul>
            <li>Raids</li>
            <li>Raid Zones</li>
            <li>Bosses</li>
            <li>Raid Fights</li>
            <li><a href="{{ route('admin.stats') }}">Character Stats</a></li>
        </ul>
    </section>
</div>
@stop