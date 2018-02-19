@extends($layout)

@section('content')

<?php
if (!isset($user)) {
    $user = new \WoWStats\User();
}

$logs = $raid->getLogsUrl();
if ($logs) {
    $warcraftLogs = "https://www.warcraftlogs.com/reports/{$logs}";
    $wipefest = "https://www.wipefest.net/report/{$logs}";
    ?>
    <h3><a href="<?=$warcraftLogs;?>">WL</a> <?php if ($user->can('administrate')) { echo "<a href='{$wipefest}'>Wipefest</a>"; } ?></h3>
    <?php
}
?>

@if ($user->can('administrate'))
@include('raids.fights._createModal')
@include('raids.attendees._addAttendeeModel')
@endif

<div class="row">
    <div class="col-xs-12 col-sm-8">
        <h1>{{ $raid->zone->name }} ({{ $raid->difficulty() }})</h1>
        <h2>{{ $raid->date }}</h2>

        <h3>Fights @if ($raid->locked == 0 && $user->can('administrate')) <button data-toggle="modal" data-target="#createRaidFightModal" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Create Fight</button> @endif</h3>
        @include('raids.fights._list')
    </div>
    <div class="col-xs-12 col-sm-4">
        <div class="card">
            <div class="card-header">

            </div>
        </div>

        <h3>Attendees @if ($raid->locked == 0 && $user->can('administrate')) <button data-toggle="modal" data-target="#addAttendeeModal" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> Add Attendee</button> @endif</h3>
        @include('raids.attendees._list')
    </div>
</div>
@endsection
