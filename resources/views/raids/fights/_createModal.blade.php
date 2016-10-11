<?php
    $raidFightModal = [
        'item' => 'RaidFight',
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
            'raid_id' => $raid->id,
        ],
        'url' => route('api.post.raid.fight', $raid->id),
        'done' => 'reload',
    ];
?>
@include('bootstrap3.components._createModal', $raidFightModal)
