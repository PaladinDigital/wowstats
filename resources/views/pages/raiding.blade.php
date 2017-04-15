@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-xs-12 col-sm-6">
            <h1>Raiding Teams</h1>

            <h2>Progression Team</h2>
            <p>Our progression team trailblaze new content to learn the tactics and get boss kills under out belt prior to opening up the raid to the guild raid team.</p>
            @if (isset($progression_team) && !empty($progression_team))
                <h3>Roster</h3>

                @foreach($progression_team as $role => $characters)
                    <h4>{{ $role }}</h4>
                    <ul>
                        @foreach ($characters as $c)
                            <li class="{{ $c->cssClass() }}">{{ $c->name }}</li>
                        @endforeach
                    </ul>
                @endforeach
            @endif

            <h2>Guild Raid Team</h2>
            <p>The guild raid team raids regularly as well, consists of a large amount of our progression team as well as guild members who want to raid and trial for the progression team.</p>
            @if (isset($raid_team) && !empty($raid_team))
                <h3>Roster</h3>
                @foreach($raid_team as $role => $characters)
                    <h4>{{ $role }}</h4>
                    <ul>
                        @foreach ($characters as $c)
                            <li class="{{ $c->cssClass() }}">{{ $c->name }}</li>
                        @endforeach
                    </ul>
                @endforeach
            @endif
        </div>


        <div class="col-xs-12 col-sm-6">
            <h1>Raiding Rules</h1>
            <ul>
                <li>All Raid Start Times are in Server Time.</li>
                <li>Raiders must use the appropriate flasks/food/runes etc.</li>
                <li>Raids last until at least 23:00 server time unless otherwise stated. We expect all members of the progression team to stay until the end unless the officers are made aware beforehand.</li>
                <li>Currently the officers are running the raids, listen to what they are telling you. If you think you could be a raid leader then speak to the officers about it.</li>
            </ul>

            <h2>How To Join</h2>
            If you would like to join the progression team there are additional requirements in order to ensure we are not carrying members through content.
            <ul>
                <li>ALL: Ability to follow tactics. (Assessed by committee decision by the officers).</li>
                <li>ALL: Ability to remain focused during the fights (ie not tunnel visioning and standing in shit).</li>
                <li>ALL: No pugging content prior to running it with the guild.</li>
                <li>DPS: Minimum of 250k DPS, this will be assessed on guild raid runs (Subject to other factors such as moving out of shit etc).</li>
                <li>Healers: Dispelling appropriately when required.  Reducing overhealing where possible.</li>
            </ul>
        </div>
    </div>
@endsection
