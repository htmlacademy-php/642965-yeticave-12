<?php
session_start();
require __DIR__ . '/init.php'; //Файл инициализации приложения

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!is_numeric($id) || $id <= 0) {
    http_response_code(404);
    die;
}

$lot_card = getLotID($connection, $id);

if (is_null($lot_card)) {
    http_response_code(404);
    die;
}

$page_content = include_template('lot_main.php', [
    'categories' => $categories,
    'lot_card' => $lot_card,
]);

$layout_content = include_template('layout.php', [
    'page_title' => $lot_card['lot_name'],
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
