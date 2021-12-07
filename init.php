<?php
require __DIR__ . '/functions/templates.php'; // подключение функций для работы с шаблоном.
require __DIR__ . '/functions/validation.php'; // подключение функций для валидации формы.
require __DIR__ . '/functions/db.php'; // подключение функций для работы с бд.

if (!file_exists( __DIR__ . '/config/config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg,E_USER_ERROR);
}

$config = require __DIR__ . '/config/config.php'; // Подключение файла конфигурации.

error_reporting(E_ALL);
ini_set('display_errors', $config['env_local']);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Ресурс соединения с бд
$connection = dbConnect($config['db']);

// Получение списка категорий, общий запрос для всех страниц
$categories = getCategories($connection);

date_default_timezone_set($config['time_zone']);
