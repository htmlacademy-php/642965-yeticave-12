<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!is_numeric($id) || $id <= 0) {
    // TODO: Переделать на вывод страницы с ошибкой.
    http_response_code(404);
    die;
}

$lotCard = getLotID($connection, $id);

if (is_null($lotCard)) {
    // TODO: Переделать на вывод страницы с ошибкой.
    http_response_code(404);
    die;
}

$currentPrice = $lotCard['price_start'];
$bets = getLotBets($connection, $id);
$betsCount = count($bets);

if (!empty($bets)) {
    $currentPrice = max(array_column($bets, 'price'));
}

// Валидация формы добавления ставки к лоту.
if (isset($_SESSION['name']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $cost = filter_input(INPUT_POST, 'cost', FILTER_DEFAULT);
    $errors['step'] = validateStep($cost, $currentPrice, $lotCard['bid_step']);
    $errors = array_filter($errors);

    if (!isset($errors['step'])) {
        //Добавляет в таблицу ставок, новую ставку.
        inBets($connection, $cost, $id, $_SESSION['id']);

        $bets = getLotBets($connection, $id);
        $currentPrice = max(array_column($bets, 'price'));
        $betsCount = count($bets);
    }
}

$pageContent = includeTemplate('lot_main.php', [
    'categories' => $categories,
    'lotCard' => $lotCard,
    'bets' => $bets,
    'errors' => $errors,
    'betsCount' => $betsCount,
    'currentPrice' => $currentPrice,
]);

$layoutContent = includeTemplate('layout.php', [
    'pageTitle' => $lotCard['lot_name'],
    'pageContent' => $pageContent,
    'categories' => $categories,
]);

echo $layoutContent;

var_dump($userId);
