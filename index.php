<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

$lots = getLots($connection, $config['limit']);

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
