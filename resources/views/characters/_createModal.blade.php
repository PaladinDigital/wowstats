<?php
$classes = new \WoWStats\Models\WoW\Classes();
$raidModal = [
    'item' => 'Character',
    'fields' => [
        [
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name'
        ],
        [
            'name' => 'class_id',
            'type' => 'select',
            'label' => 'Class',
            'options' => $classes->getOptions(),
        ],
    ],
    'url' => route('api.post.raid'),
    'done' => 'reload',
];
?>
@include('bootstrap3.components._createModal', $raidModal)
