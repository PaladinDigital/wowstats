@if($user->can('administrate'))
    @if ($fight->locked === 0)
        <button class="btn btn-danger pull-right" onclick="return lockFight({{$fight->id}});">Lock Fight</button>
    @else
        <button class="btn btn-danger pull-right" onclick="return unlockFight({{$fight->id}});">Unlock Fight</button>
    @endif
@endif