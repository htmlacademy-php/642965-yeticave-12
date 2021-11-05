<?php
session_start();
require __DIR__ . '/init.php'; //Файл инициализации приложения

$product_card = getLots($connection);

$page_content = include_template('index_main.php', [
    'categories' => $categories,
    'product_card' => $product_card,
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Аукцион горнолыжного оборудования',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
