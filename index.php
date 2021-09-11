<?php
require_once 'functions.php';
$is_auth = rand(0, 1);
$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$product_card = [
    [
    'name' => '2014 Rossignol District Snowboard',
    'category' => 'Доски и лыжи',
    'price' => '10999',
    'url_image' => 'img/lot-1.jpg',
    'lot_expiration_date' => '2021-09-16'
    ],
    [
    'name' => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => 'Доски и лыжи',
    'price' => '159999',
    'url_image' => 'img/lot-2.jpg',
    'lot_expiration_date' => '2021-09-15'
    ],
    [
    'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category' => 'Крепления',
    'price' => '8000',
    'url_image' => 'img/lot-3.jpg',
    'lot_expiration_date' => '2021-09-14'
    ],
    [
    'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
    'category' => 'Ботинки',
    'price' => '10999',
    'url_image' => 'img/lot-4.jpg',
    'lot_expiration_date' => '2021-09-13'
    ],
    [
    'name' => 'Куртка для сноуборда DC Mutiny Charocal',
    'category' => 'Одежда',
    'price' => '7500',
    'url_image' => 'img/lot-5.jpg',
    'lot_expiration_date' => '2021-09-12'
    ],
    [
    'name' => 'Маска Oakley Canopy',
    'category' => 'Разное',
    'price' => '5400',
    'url_image' => 'img/lot-6.jpg',
    'lot_expiration_date' => 'tomorrow'
    ]
];

$page_content = include_template('main.php', [
    'categories' => $categories,
    'product_card' => $product_card
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Аукцион горнолыжного оборудования',
    'user_name' => 'Григорий',
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);

echo $layout_content;
