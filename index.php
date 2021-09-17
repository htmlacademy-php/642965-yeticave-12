<?php
require_once 'functions.php';
$db = require_once 'config/config.php';
$is_auth = rand(0, 1);

if (!file_exists('config/config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg,E_USER_ERROR);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$con = new mysqli($db['host'], $db['username'], $db['password'], $db['dbname']);
$con->set_charset($db['charset']);

$sql_categories = 'SELECT name_cat, symbol FROM categories';

$sql_lots = 'SELECT name_lot, price_start, image, name_cat, dt_complete FROM lots, categories c
                WHERE category_id = c.id AND dt_complete > NOW() ORDER BY dt_create DESC';

$result_categories = $con->query($sql_categories);
$result_lots = $con->query($sql_lots);

$categories = $result_categories->fetch_all(MYSQLI_ASSOC);
$product_card = $result_lots->fetch_all(MYSQLI_ASSOC);

$page_content = include_template('main.php', [
    'categories' => $categories,
    'product_card' => $product_card,
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Аукцион горнолыжного оборудования',
    'user_name' => 'Григорий',
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
