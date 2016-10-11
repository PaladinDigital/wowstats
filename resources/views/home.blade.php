@extends('layouts.app')

@section('content')
    @if (isset($characters))

    @else
        <p>You currently have no characters assigned to your account.</p>
    @endif
@endsection
