@if (\Auth::check())
@if ($character->user_id === null)
    <button onclick="return claimCharacter({{ $character->id }})" class="claim btn btn-sm btn-primary">Claim Character</button>
@else
    <button onclick="return unclaimCharacter({{ $character->id }})" class="unclaim btn btn-sm btn-warning">Unclaim Character</button>
@endif
@endif