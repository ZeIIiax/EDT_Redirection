<?php
$groupe = '<Name of your Group>';
$cours =[
    //Lesson1, Monday at 11H30 to 13H00 and Friday at 8H00 to 9H30 with link <Zoom link>
    'Lesson1' =>[
        'horaire' => [
            [
            'jour' => 'Mon',
            'heure' => [['11','30'],['13','0']],
            ],
            [
            'jour' => 'Fri',
            'heure' => [['8','00'],['9','30']],
            ],
        ],
        'link' =>'<Zoom link>',
    ]
];?>

//Copy and Paste Tab for add Lessons
