@if (\Auth::check())
    @if (!$character->isOwned())
        <button onclick="return claimCharacter({{ $character->id }})" class="claim btn btn-sm btn-primary">Claim Character</button>
    @elseif ($character->isUsers())
        <button onclick="return unclaimCharacter({{ $character->id }})" class="unclaim btn btn-sm btn-warning">Unclaim Character</button>
    @endif
@endif