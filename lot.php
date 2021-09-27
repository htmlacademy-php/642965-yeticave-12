<?php
require 'init.php'; //Файл инициализации приложения

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
}
else {
    http_response_code(404);
    exit;
}

$sql_lot = 'SELECT l.id, name_lot, image, name_cat, description, price_start, dt_complete
            FROM lots l JOIN categories c ON category_id = c.id WHERE l.id =' . $id;

$result_lot = $con->query($sql_lot);
$lot_card = $result_lot->fetch_assoc();

if (!isset($lot_card)) {
    http_response_code(404);
}

$page_content = include_template('lot_main.php', [
    'categories' => $categories,
    'lot_card' => $lot_card,
]);

$layout_content = include_template('layout.php', [
    'page_title' => $lot_card['name_lot'],
    'user_name' => 'Григорий',
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
