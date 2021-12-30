<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

$userId = getUserIdFromSession();
$myBets = getMyBets($connection, $userId);

$pageContent = includeTemplate('my-bets.php', [
    'categories' => $categories,
    'myBets' => $myBets,
    'userId' => $userId,
]);

$layoutContent = includeTemplate('layout.php', [
    'pageTitle' => 'Мои ставки',
    'pageContent' => $pageContent,
    'categories' => $categories,
]);

echo $layoutContent;
