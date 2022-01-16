<?php

return [
    'db' => [ // Настройки подключения к бд
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'port' => '3306',
        'dbname' => 'yeticave_new',
        'charset' => 'utf8mb4',
    ],
    'email' => [ // Настройки (dsn) траспорта
        'user' => 'fd2c6cd72bf938',
        'password' => '6cb1408e5976ed',
        'smtp' => 'smtp.mailtrap.io',
        'port' => '2525',
        'from' => 'keks@phpdemo.ru',
    ],
    'pagination' => [
        'mainLotsQuantity' => 6, // Кол-во лотов отображаемых на главной странице
        'categoryLotsPerPage' => 9, // Кол-во лотов отображаемых на страницах 'лоты по категориям' и 'страница поиска'
    ],
    'env_local' => 'true',
    'time_zone' => 'Europe/Moscow', // часовой пояс
    'baseUrl' => 'http://' . '642965-yeticave-12', // <адрес домен> к сайту
];
