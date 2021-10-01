<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!is_numeric($id) || $id <= 0) {
    http_response_code(404);
    die;
}

$sql_lot = 'SELECT l.id, name_lot, image, name_cat, description, price_start, dt_complete
            FROM lots l JOIN categories c ON category_id = c.id WHERE l.id = ?';

$stmt = $con->prepare($sql_lot);
$stmt->bind_param('i', $id);
$stmt->execute();
$result_lot = $stmt->get_result();
$lot_card = $result_lot->fetch_assoc();

if (is_null($lot_card)) {
    http_response_code(404);
    die;
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
