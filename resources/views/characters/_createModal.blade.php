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
        [
            'name' => 'main_role_id',
            'type' => 'select',
            'label' => 'Primary Role',
            'options' => \WoWStats\Models\CharacterRole::getOptions(),
        ],
        [
            'name' => 'os_role_id',
            'type' => 'select',
            'label' => 'Secondary Role',
            'options' => \WoWStats\Models\CharacterRole::getOptions(),
        ],
    ],
    'url' => route('api.post.raid'),
    'done' => 'reload',
];
?>
@include('bootstrap3.components._createModal', $raidModal)
