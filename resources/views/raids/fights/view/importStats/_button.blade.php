@if ( isset($user) && $user->can('administrate') && $fight->locked < 1 )
    <a class="btn btn-sm btn-primary pull-right" href="{{ route('raid.fight.import', [$raid->id, $fight->id]) }}">
        <i class="fa fa-plus"></i> CSV Import
    </a>
@endif