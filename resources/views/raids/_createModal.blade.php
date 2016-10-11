<?php
    $raidModal = [
        'item' => 'Raid',
        'fields' => [
            [
                'name' => 'date',
                'type' => 'date',
                'label' => 'Date'
            ],
            [
                'name' => 'time',
                'type' => 'time',
                'label' => 'Time'
            ],
            [
                'name' => 'raidzone_id',
                'type' => 'select',
                'label' => 'Raid Zone',
                'options' => $raidzones
            ]
        ],
        'url' => route('api.post.raid'),
        'done' => 'reload',
    ];
?>
@include('bootstrap3.components._createModal', $raidModal)
