<?php

return [
    'app' => [
        'label'  => 'General',
        'fields' => [
            'name' => [
                'label' => 'Application Name',
                'type'  => 'text', // textarea, image, file, ...
            ],
            'description' => [
                'label' => 'Application Description',
                'type'  => 'textarea',
            ],
            'logo' => [
                'label' => 'Application Logo',
                'type'  => 'image',
            ],
            'robots' => [
                'label' => 'Robots.txt',
                'type'  => 'textarea',
            ],
        ],
    ],
];