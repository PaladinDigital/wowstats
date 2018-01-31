@extends('layouts.admin')

@section('content')

    <section>
        <h1>Dashboard</h1>
        @include('admin/widgets/_statsWidget', ['class' => '', 'stat' => 'Users', 'value' => $stats['users']])
        @include('admin/widgets/_statsWidget', ['class' => '', 'stat' => 'Raids', 'value' => $stats['raids']])
    </section>

    <section>
        <h1>Administration</h1>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('admin.users') }}">Users</a></li>
            <li class="list-group-item"><a href="{{ route('admin.characters') }}">Characters</a></li>
            <li class="list-group-item"><a href="{{ route('admin.stats') }}">Character Stats</a></li>
        </ul>
    </section>
</div>
@stop