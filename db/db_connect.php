<?php
//Файл подключения к базе данных
$db = require 'config/config.php'; // Получение параметров для подключения к бд.

error_reporting(E_ALL);
ini_set('display_errors', $db['env_local']);

if (!file_exists('config/config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg,E_USER_ERROR);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Ресурс соединения с бд
$con = new mysqli($db['host'], $db['username'], $db['password'], $db['dbname']);
$con->set_charset($db['charset']);
// Получение списка категорий, общий запрос для всех страниц
$sql_categories = 'SELECT name_cat, symbol FROM categories';
$result_categories = $con->query($sql_categories);
$categories = $result_categories->fetch_all(MYSQLI_ASSOC);
