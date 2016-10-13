@extends('layouts.app')

@section('content')
    <h1 class="{{ $character->cssClass() }}">{{ $character->name }}</h1>
    <p>Main Spec: {{ $character->mainSpec() }}, Off-Spec: {{ $character->offSpec() }}</p>
@endsection
