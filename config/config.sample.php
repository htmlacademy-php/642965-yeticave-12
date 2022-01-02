<?php

return [
    'db' => [ // Настройки подключения к бд
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'port' => '3306',
        'dbname' => 'yeticave_new',
        'charset' => 'utfmb4',
    ],
    'email' => [ // Настройки (dsn) траспорта
        'user' => 'fd2c6cd72bf938',
        'password' => '6cb1408e5976ed',
        'smtp' => 'smtp.mailtrap.io',
        'port' => '2525',
        'from' => 'keks@phpdemo.ru',
    ],
    'env_local' => 'true',
    'limit' => '6', // колличество отображаемых лотов на странице
    'time_zone' => 'Europe/Kaliningrad', // часовой пояс
    'baseUrl' => 'http://' . $_SERVER['HTTP_HOST'], // <адрес домен> к сайту
];
