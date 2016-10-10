@extends('layouts.app')

@section('content')
    <h1>Raids <button class="pull-right" data-toggle="modal" data-target="#createRaidModal">Create Raid</button></h1>
    @include('raids._createModal')

    @if (count($raids) > 0)
        <raids-list></raids-list>
    @else
        <p>No raids have been recorded yet.</p>
    @endif
@endsection
