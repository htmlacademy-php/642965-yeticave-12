<?php
session_start();
require __DIR__ . '/init.php'; //Файл инициализации приложения
$errors = [];

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

$current_price = $lot_card['price_start'];
$bets = getLotBets($connection, $id);
$bets_count = count($bets);

if (!empty($bets)) {
    $current_price = max(array_column($bets, 'price'));
}

// Валидация формы добавления ставки к лоту.
if (isset($_SESSION['name']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $cost = filter_input(INPUT_POST, 'cost', FILTER_DEFAULT);
    $errors['step'] = validateStep($cost, $current_price, $lot_card['bid_step']);
    $errors = array_filter($errors);

    if (!isset($errors['step'])) {
        //Добавляет в таблицу ставок, новую ставку.
        inBets($connection, $cost, $id, $_SESSION['id']);

        $bets = getLotBets($connection, $id);
        $current_price = max(array_column($bets, 'price'));
        $bets_count = count($bets);
    }
}

$page_content = include_template('lot_main.php', [
    'categories' => $categories,
    'lot_card' => $lot_card,
    'bets' => $bets,
    'errors' => $errors,
    'bets_count' => $bets_count,
    'current_price' => $current_price,
]);

$layout_content = include_template('layout.php', [
    'page_title' => $lot_card['lot_name'],
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
