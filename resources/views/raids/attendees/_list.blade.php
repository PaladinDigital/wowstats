@if (isset($attendees) && count($attendees) > 0)
    <ul>
        @foreach($attendees as $a)
            <ul class="{{ $a->character->cssClass() }}">{{ $a->character->name }}</ul>
        @endforeach
    </ul>
@endif
