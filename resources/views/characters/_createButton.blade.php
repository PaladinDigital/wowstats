@if (isset($user) && $user->can('administrate'))
<button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#createCharacterModal">Create Character</button>
@endif
