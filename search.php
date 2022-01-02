<?php
/** @var mysqli $connection */
/** @var array $categories */

require __DIR__ . '/init.php'; //Файл инициализации приложения
$itemsCount = 0;
$lots = [];

$currentPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$currentPage = (is_numeric($currentPage) && $currentPage > 0) ? $currentPage : 1;

if (isset($_GET['find']) || isset($_GET['page'])) {
    $searchStr = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS));

    if (!empty($searchStr)) {
        $itemsCount = numRowsSearchLots($connection, $searchStr);

        $offset = ($currentPage - 1) * $config['limit'];
        $lots = getSearchLots($connection, $searchStr, $config['limit'], $offset);
    }
}

$pagesCount = ceil($itemsCount / $config['limit']);
$pages = range(1, $pagesCount);

$pageContent = includeTemplate('search_lot.php', [
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
