@extends($layout)

@section('content')
    <h1>Characters @include('characters._createButton')</h1>
    @if (isset($user) && $user->can('administrate'))
        @include('characters._createModal')
    @endif

    @if (count($characters) > 0)
        <table class="table table-striped characters">
            <thead>
            <tr>
                <th>Character</th>
                <th>Class</th>
                <th>Main Spec</th>
                <th>Off-Spec</th>
                <th>Links</th>
            </tr>
            </thead>
            <tbody>
            @foreach($characters as $c)
                <tr class="{{ $c->cssClass() }}">
                    <td><a href="{{ route('character.view', $c->name) }}">{{ $c->name }}</a></td>
                    <td>{{ $c->className() }}</td>
                    <td><i class="{{ $c->mainSpecIcon() }}"></i></td>
                    <td><i class="{{ $c->offSpecIcon() }}"></i></td>
                    <td>
                        @if ($c->hasLink('armory'))
                            <a href="{{ $c->getLink('armory') }}"><img class="profile-icon" src="{{ asset('images/icons/wow-favicon.png') }}" alt="{{ $c->name }}'s Armory Profile" /></a>
                        @endif
                        @if ($c->hasLink('askmrrobot'))
                            <a href="{{ $c->getLink('askmrrobot') }}"><img class="profile-icon" src="{{ asset('images/icons/amr-favicon.png') }}" alt="{{ $c->name }}'s AskMrRobot Profile" /></a>
                        @endif
                        @if ($c->hasLink('raider.io'))
                            <a href="{{ $c->getLink('raider.io') }}"><img class="profile-icon" src="{{ asset('images/icons/raiderio-favicon.ico') }}" alt="{{ $c->name }}'s Raider.io Profile" /></a>
                        @endif
                            @if ($c->hasLink('warcraftlogs'))
                                <a href="{{ $c->getLink('warcraftlogs') }}">WL</a>
                            @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $characters->render() }}
    @else
        <p>No characters have been added yet.</p>
    @endif
@endsection
