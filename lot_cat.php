<?php
/** @var mysqli $connection */
/** @var array $categories */

require __DIR__ . '/init.php';
$itemsCount = 0;
$lots = [];

$currentPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$currentPage = (is_numeric($currentPage) && $currentPage > 0) ? $currentPage : 1;

if (isset($_GET['cat_name'])) {
    $catName = filter_input(INPUT_GET, 'cat_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $itemsCount = numRowsLotsCategory($connection, $catName);

    $offset = ($currentPage - 1) * $config['pagination']['categoryLotsPerPage'];
    $lots = getLotsCategory($connection, $catName, $config['pagination']['categoryLotsPerPage'], $offset);
}

$pagesCount = ceil($itemsCount / $config['pagination']['categoryLotsPerPage']);
$pages = range(1, $pagesCount);

$pageContent = includeTemplate('lot_category.php', [
    'categories' => $categories,
    'lots' => $lots,
    'currentPage' => $currentPage,
    'pagesCount' => $pagesCount,
    'pages' => $pages,
]);

$layoutContent = includeTemplate('layout.php', [
    'pageTitle' => 'Результат поиска',
    'pageContent' => $pageContent,
    'categories' => $categories,
]);

echo $layoutContent;

