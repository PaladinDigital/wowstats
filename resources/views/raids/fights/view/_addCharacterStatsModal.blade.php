<?php
$attendee_options = [];
foreach ($attendees as $a) {
    $attendee_options[$a->character->id] = $a->character->name;
}
$raidFightModal = [
    'item' => 'CharacterStats',
    'fields' => [
        [
            'name'  => 'character_id',
            'label' => 'Character',
            'type'  => 'select',
            'options' => $attendee_options,
        ],
        [
            'name'  => 'metric_id',
            'label' => 'Stat',
            'type'  => 'select',
            'options' => $metrics,
        ],
        [
            'name'  => 'value',
            'label' => 'Value',
            'type'  => 'number',
        ]
    ],
    'hidden_fields' => [
        'fight_id' => $fight->id,
    ],
    // Convert mm:ss to seconds.
    'url' => route('api.post.character.stats'),
    'done' => 'reload',
];
?>
@include('bootstrap3.components._createModal', $raidFightModal)
