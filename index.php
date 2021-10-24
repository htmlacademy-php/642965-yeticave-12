<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

$sql_lots = 'SELECT l.id, name_lot, price_start, image, name_cat, dt_complete
             FROM lots l, categories c WHERE category_id = c.id AND dt_complete > NOW() ORDER BY dt_create DESC';

$result_lots = $con->query($sql_lots);
$product_card = $result_lots->fetch_all(MYSQLI_ASSOC);

$page_content = include_template('index_main.php', [
    'categories' => $categories,
    'product_card' => $product_card,
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Аукцион горнолыжного оборудования',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
