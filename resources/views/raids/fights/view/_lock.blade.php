@if($user->can('administrate'))
    @if ($fight->locked === 0)
        <button class="btn btn-danger btn-sm pull-right" onclick="return lockFight({{$fight->id}});"><i class="fa fa-lock"></i> Lock Fight</button>
    @else
        <button class="btn btn-danger btn-sm pull-right" onclick="return unlockFight({{$fight->id}});"><i class="fa fa-unlock"></i> Unlock Fight</button>
    @endif
@endif