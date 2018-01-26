@extends($layout)

@section('content')
    @if (count($user->characters) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">My Characters</div>
            <div class="panel-body">
                <ul class="list-group">
                @foreach($user->characters as $character)
                    <li class="{{ $character->cssClass() }}"><a href="{{ route('character.view', $character->name) }}">{{ $character->name }}</a></li>
                @endforeach
                </ul>
            </div>
        </div>
    @else
        <p>You currently have no characters assigned to your account.</p>
    @endif
@endsection
