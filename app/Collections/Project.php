<?php

namespace App\Collections;

class Project {
    
    public static function getCollection(): array {
        return [
            'icon' => 'http://127.0.0.1:8000/storage/media/H6OyfuxHjnP4Ncsryl7eBm2V4YxIjOdCEfZhaEfF.svg',
            'columns' => [ 'image', 'project', 'link', 'status' ],
            'meta' => [
                'project' => [
                    'control' => 'text',
                    'default' => 'Awesome Project'
                ],
                'general_group' => [
                    'fields' => [
                        'image' => [ 'control' => 'image' ],
                        'gallery' => [ 'control' => 'images' ],
                    ]
                ],
                'description' => [ 'control' => 'textarea' ],
                'technical_group' => [
                    'fields' => [
                        'link' => [ 'control' => 'text' ],
                        'framework' => [ 'control' => 'text' ],
                        'status' => [
                            'control' => 'select',
                            'default' => 'On-going',
                            'values' => [
                                'On-going' => 'On-going',
                                'Done' => 'Done'
                            ]
                        ],
                        'sticky' => [
                            'control' => 'checkbox',
                            'default' => ['Sticky'],
                            'values' => [
                                'Sticky' => 'Sticky'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

}