<?php
session_start();
require __DIR__ . '/init.php'; //Файл инициализации приложения
$lots = [];

$current_page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$current_page = (is_numeric($current_page) && $current_page > 0) ? $current_page : 1;

if (isset($_GET['find']) || isset($_GET['page'])) {
    $search_str = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS));
    $items_count = 0;

    if (!empty($search_str)) {
        $items_count = numRowsSearchLots($connection, $search_str);

        $offset = ($current_page - 1) * $config['limit'];
        $lots = getSearchLots($connection, $search_str, $config['limit'],$offset);
    }
}

$pages_count = ceil($items_count / $config['limit']);
$pages = range(1, $pages_count);

$pageContent = includeTemplate('search_lot.php', [
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
