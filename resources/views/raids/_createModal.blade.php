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
            ],
            [
                'name' => 'difficulty_id',
                'type' => 'select',
                'label' => 'Difficulty',
                'options' => [
                    0 => 'LFR',
                    1 => 'Normal',
                    2 => 'Heroic',
                    3 => 'Mythic',
                ]
            ],
            [
                'name' => 'wl_url',
                'type' => 'text',
                'label' => 'Warcraft Logs URL'
            ]
        ],
        'url' => route('api.post.raid'),
        'done' => 'reload',
    ];
?>
@can('create', \WoWStats\Models\Raid::class)
@include('bootstrap4.components._createModal', $raidModal)
@endcan