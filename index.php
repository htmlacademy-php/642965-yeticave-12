<?php
/** @var mysqli $connection */
/** @var array $categories */
/** @var array $config */

require __DIR__ . '/init.php'; //Файл инициализации приложения
require __DIR__ . '/getwinner.php'; // Определение победителя

$lots = getLots($connection, $config['pagination']['mainLotsQuantity']);

$pageContent = includeTemplate('index_main.php', [
    'categories' => $categories,
    'lots' => $lots,
]);

$layoutContent = includeTemplate('layout.php', [
    'pageTitle' => 'Аукцион горнолыжного оборудования',
    'pageContent' => $pageContent,
    'categories' => $categories,
]);

echo $layoutContent;
