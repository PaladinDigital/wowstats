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
        'pre_send' => "var len = $('#length').val();
        var mins = len.substring(0, 2);
        var secs = parseInt(len.substring(3, 5));
        var min_sec = mins * 60;
        var total_sec = min_sec + secs;
        data.length = total_sec",
        'url' => route('api.post.raid.fight', $raid->id),
        //'done' => 'reload',
    ];
?>
@include('bootstrap3.components._createModal', $raidFightModal)
