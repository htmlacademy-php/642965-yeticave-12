<?php
require __DIR__ . '/functions.php'; // Подключение пользовательских функций.

if (!file_exists( __DIR__ . '/config/config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg,E_USER_ERROR);
}

$config = require __DIR__ . '/config/config.php'; // Подключение файла конфигурации.
$db = $config['db'];

error_reporting(E_ALL);
ini_set('display_errors', $config['env_local']);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Ресурс соединения с бд
$con = new mysqli($db['host'], $db['username'], $db['password'], $db['dbname']);
$con->set_charset($db['charset']);

// Получение списка категорий, общий запрос для всех страниц
$sql_categories = 'SELECT id, name_cat, symbol FROM categories';
$result_categories = $con->query($sql_categories);
$categories = $result_categories->fetch_all(MYSQLI_ASSOC);
