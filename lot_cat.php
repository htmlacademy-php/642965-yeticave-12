<?php
session_start();
require __DIR__ . '/init.php';
$items_count = 0;
$lots = [];

$current_page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$current_page = (is_numeric($current_page) && $current_page > 0) ? $current_page : 1;

if ($_GET['cat_name']) {
    $cat_name = filter_input(INPUT_GET, 'cat_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $items_count = numRowsLotsCategory($connection, $cat_name);

    $offset = ($current_page - 1) * $config['limit'];
    $lots = getLotsCategory($connection, $cat_name, $config['limit'], $offset);
}

$pages_count = ceil($items_count / $config['limit']);
$pages = range(1, $pages_count);

$pageContent = includeTemplate('lot_category.php', [
    'categories' => $categories,
    'lots' => $lots,
    'current_page' => $current_page,
    'pages_count' => $pages_count,
    'pages' => $pages,
]);

$layoutContent = includeTemplate('layout.php', [
    'pageTitle' => 'Результат поиска',
    'pageContent' => $pageContent,
    'categories' => $categories,
]);

echo $layoutContent;

