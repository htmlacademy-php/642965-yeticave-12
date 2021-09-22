<?php
require 'functions.php';
require 'db/db_connect.php'; //подключение к бд и получение списка категорий

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
}
else {
    $id = 0;
    http_response_code(404);
}

$sql_lot = 'SELECT l.id, name_lot, image, name_cat, description, price_start, dt_complete
            FROM lots l JOIN categories c ON category_id = c.id WHERE l.id =' . $id;

$result_lot = $con->query($sql_lot);
$lot_card = $result_lot->fetch_assoc();

if (!isset($lot_card)) {
    http_response_code(404);
}

$lot_content_right = include_template('lot_content_right.php', [
    'lot_card' => $lot_card,
]);

$lot_content = include_template('lot_content.php', [
    'lot_card' => $lot_card,
    'lot_content_right' => $lot_content_right,
]);

$lot_page = include_template('lot_page.php', [
    'lot_card' => $lot_card,
    'categories' => $categories,
    'lot_content' => $lot_content,
]);

echo $lot_page;
