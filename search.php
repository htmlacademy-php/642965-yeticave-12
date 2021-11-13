<?php
session_start();
require __DIR__ . '/init.php'; //Файл инициализации приложения
$search_lots = [];
$page_limit = 3;
$current_page = $_GET['page'] ?? 1;

if (isset($_GET['find']) || isset($_GET['page'])) {
    $search_str = trim($_GET['search']);
    $items_count = 0;

    if (!empty($search_str)) {
        $items_count = getNumRows($connection, $search_str);

        $offset = ($current_page - 1) * $page_limit;
        $search_lots = getSearchLots($connection, $search_str, $page_limit,$offset);
    }
}

$pages_count = ceil($items_count / $page_limit);
$pages = range(1, $pages_count);

$page_content = include_template('search_lot.php', [
    'categories' => $categories,
    'search_lots' => $search_lots,
    'current_page' => $current_page,
    'pages_count' => $pages_count,
    'pages' => $pages,
    ]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Результат поиска',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
