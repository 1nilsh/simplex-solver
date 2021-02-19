<?php

return [
    'zf' => [
        'typ' => 'min',
        'b' => -20,
        'x' => [
            'x1' => -10,
            'x2' => -8
        ]

    ],
    'st' => [
        [
            'x' => [
                'x1' => 1,
                'x2' => 2,
            ],
            'operator' => '<=',
            'schranke' => 8
        ],
        [
            'x' => [
                'x1' => -3,
                'x2' => 1,
            ],
            'operator' => '<=',
            'schranke' => 6
        ],
        [
            'x' => [
                'x1' => 1,
                'x2' => 2,
            ],
            'operator' => '<=',
            'schranke' => 6
        ],
    ]
];
