<?php

return [
    'database' => [
        'name' => 'vendon_task',
        'username' => 'root',
        'password' => 'option123',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
