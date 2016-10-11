<?php
$raidFightModal = [
    'item' => 'CharacterStat',
    'fields' => [
            [
                    'name'    => 'boss_id',
                    'type'    => 'select',
                    'label'   => 'Boss',
                    'options' => $bosses
            ],
            [
                    'name'  => 'killed',
                    'label' => 'Killed',
                    'type'  => 'select',
                    'options' => [
                            0 => 'No',
                            1 => 'Yes',
                    ]
            ],
            [
                    'name'  => 'length',
                    'label' => 'Fight Length',
                    'type'  => 'time'
            ]
    ],
    'hidden_fields' => [
        'fight_id' => $fight->id,
    ],
    // Convert mm:ss to seconds.
    'url' => route('api.post.raid.fight', $raid->id),
    'done' => 'reload',
];
?>
@include('bootstrap3.components._createModal', $raidFightModal)
