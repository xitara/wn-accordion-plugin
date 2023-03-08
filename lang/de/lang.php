<?php

return [
    'plugin' => [
        'name' => 'Akkordeons',
        'description' => 'Textlisten erzeugen die als Akkordeon ausgespielt werden',
        'author' => 'Xitara SoftWerX',
        'homepage' => 'https://xitara.de',
    ],
    'submenu' => [
        'label' => 'Akkordeons',
        // 'comment' => '',
    ],
    'accordion' => [
        'singular' => 'Akkordeon',
        'plural' => 'Akkordeons',
    ],
    'textlist' => [
        'label' => 'Textliste',
        'text' => 'Text',
        'comment' => 'Überschrift 1 und Überschrift 2 sollten vermieden werden. Deren Benutzung kann sich negativ auf die Darstellung auswirken.',
        'prompt' => 'Neuen Text anlegen',
    ],
];
