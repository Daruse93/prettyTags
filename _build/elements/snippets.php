<?php

return [
    'prettyTagsCloud' => [
        'file' => 'prettyTagsCloud',
        'description' => 'prettyTags snippet to list items',
        'properties' => [
            'tvId' => [
                'type' => 'textfield',
                'value' => '',
            ],
            'tpl' => [
                'type' => 'textfield',
                'value' => 'tpl.prettyTags.item',
            ],
            'sortby' => [
                'type' => 'textfield',
                'value' => 'name',
            ],
            'sortdir' => [
                'type' => 'list',
                'options' => [
                    ['text' => 'ASC', 'value' => 'ASC'],
                    ['text' => 'DESC', 'value' => 'DESC'],
                ],
                'value' => 'ASC',
            ],
            'limit' => [
                'type' => 'numberfield',
                'value' => 10,
            ],
            'outputSeparator' => [
                'type' => 'textfield',
                'value' => "\n",
            ],
            'toPlaceholder' => [
                'type' => 'combo-boolean',
                'value' => false,
            ],
            'includeUnpublished' => [
                'type' => 'textfield',
                'value' => '0',
            ],
            'includeDeleted' => [
                'type' => 'textfield',
                'value' => '0',
            ],
        ],
    ],
    'prettyTagsResource' => [
        'file' => 'prettyTagsResource',
        'description' => 'prettyTags snippet to list items in Resource',
        'properties' => [
            'input' => [
                'type' => 'textfield',
            ],
            'tpl' => [
                'type' => 'textfield',
                'value' => 'tpl.prettyTags.item',
            ],
            'sortby' => [
                'type' => 'textfield',
                'value' => 'name',
            ],
            'sortdir' => [
                'type' => 'list',
                'options' => [
                    ['text' => 'ASC', 'value' => 'ASC'],
                    ['text' => 'DESC', 'value' => 'DESC'],
                ],
                'value' => 'ASC',
            ],
            'limit' => [
                'type' => 'numberfield',
                'value' => 10,
            ],
            'outputSeparator' => [
                'type' => 'textfield',
                'value' => "\n",
            ],
            'toPlaceholder' => [
                'type' => 'combo-boolean',
                'value' => false,
            ],
        ],
    ],
];
