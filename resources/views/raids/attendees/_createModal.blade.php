<?php
$raidModal = [
    'item' => 'RaidAttendee',
    'fields' => [
        [
            'name' => 'character_id',
            'type' => 'select',
            'label' => 'Character',
            'options' => \WoWStats\Models\Character::all(),
        ]
    ],
    'hidden_fields' => [
        'raid_id' => $raid->id,
    ],
    'url' => route('api.post.raid.attendee', $raid->id),
    'done' => 'reload',
];
?>
@include('bootstrap3.components._createModal', $raidModal)
