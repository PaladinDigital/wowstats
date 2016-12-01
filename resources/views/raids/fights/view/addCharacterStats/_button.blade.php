@if ( isset($user) && $user->can('administrate') && $fight->locked < 1 )
    <button data-toggle="modal" data-target="#createCharacterStatsModal" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add Character Stats</button>
@endif