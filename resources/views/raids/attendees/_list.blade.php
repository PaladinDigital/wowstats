@if (isset($attendees) && count($attendees) > 0)
    <ul>
        @foreach($attendees as $a)
            <?php
                $classes = new \WoWStats\Models\WoW\Classes();
                $css_class = $classes->getDisplayName($a->character->className());
            ?>
            <ul class="{{ $css_class }}">{{ $a->character->name }}</ul>
        @endforeach
    </ul>
@endif
