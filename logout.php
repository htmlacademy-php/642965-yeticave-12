<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

$_SESSION = [];
session_destroy();

header('Location: index.php');
die();
