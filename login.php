<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

$page_content = include_template('user_login.php', [
    'categories' => $categories,
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Вход',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
