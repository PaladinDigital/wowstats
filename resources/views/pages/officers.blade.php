@extends('layouts.app')

@section('content')
    <h1>Officers</h1>

    <div class="row">
    @foreach($officers as $officer)
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title {{ $officer->cssClass }}">{{ $officer->name }} <span class="pull-right">Rank: {{ $officer->rank or '' }}</span></h2>
                </div>
                <div class="panel-body">
                    <img class="img-responsive" src="{{ asset('images/characters/' . $officer->name . '.jpg') }}">
                    <p>{{ $officer->description }}</p>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endsection
