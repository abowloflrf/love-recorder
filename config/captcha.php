<?php

return [

    'characters' => '2346789abcdefghjmnpqrtuxyz',

    'default'   => [
        'length'    => 5,
        'width'     => 80,
        'height'    => 30,
        'quality'   => 90,
    ],

    'flat'   => [
        'length'    => 4,
        'width'     => 80,
        'height'    => 30,
        'quality'   => 90,
        'lines'     => 2,
        'bgImage'   => false,
        'bgColor'   => '#e8ebee',
        'fontColors'=> ['#33393f'],
        'contrast'  => 0,
    ],

    'mini'   => [
        'length'    => 3,
        'width'     => 60,
        'height'    => 32,
    ],

    'inverse'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'sensitive' => true,
        'angle'     => 12,
        'sharpen'   => 10,
        'blur'      => 2,
        'invert'    => true,
        'contrast'  => -5,
    ]

];
