<?php
session_start();
require __DIR__ . '/init.php'; //Файл инициализации приложения

$my_bets = getMyBets($connection, $_SESSION['id']);

$page_content = include_template('my-bets.php', [
    'categories' => $categories,
    'my_bets' => $my_bets,
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Мои ставки',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
