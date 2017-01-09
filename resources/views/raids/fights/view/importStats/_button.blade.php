@if ( isset($user) && $user->can('administrate') && $fight->locked < 1 )
    <button class="btn btn-sm btn-primary pull-right">
        <i class="fa fa-plus"></i> CSV Import
    </button>
@endif