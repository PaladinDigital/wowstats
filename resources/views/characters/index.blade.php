@extends('layouts.app')

@section('content')
    <h1>Characters @include('characters._createButton')</h1>
    @if (isset($user) && $user->can('administrate'))
        @include('characters._createModal')
    @endif

    @if (count($characters) > 0)
        <table class="table table-striped">
            <thead>
            <tr><th>Character</th><th>Class</th><th>Main Spec</th><th>Off-Spec</th></tr>
            </thead>
            <tbody>
            @foreach($characters as $c)
                <tr><td>{{ $c->name }}</td>{{ $c->className() }}<td></td><td></td><td></td></tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No characters have been added yet..</p>
    @endif
@endsection
