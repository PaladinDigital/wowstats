@if (isset($attendees) && count($attendees) > 0)
    <ul class="list-group">
        @foreach($attendees as $a)
            <li class="{{ $a->character->cssClass() }}">{{ $a->character->name }}</li>
        @endforeach
    </ul>
@endif
