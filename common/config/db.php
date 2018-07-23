<?php

$config = [
	'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=sample',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
    ],


    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 6,
    ],
];
return $config;
