<?php
/** @var mysqli $connection */
/** @var array $categories */
/** @var array $errors */

require __DIR__ . '/init.php'; //Файл инициализации приложения

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rules = [
        'email' => function ($value) {
            return validateEmail($value);
        },
        'password' => function ($value) {
            return isCorrectLength($value, 8, 20);
        },
    ];

    $log = filter_input_array(INPUT_POST, ['email' => FILTER_DEFAULT, 'password' => FILTER_DEFAULT], true);

    foreach ($log as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
    }

    $errors['email'] = $errors['email'] ?? validateLogEmail($connection, $log['email']);
    $errors = array_filter($errors);

    if (!count($errors)) {
        if (password_verify($log['password'], userPassword($connection, $log['email']))) {
            $_SESSION = userID($connection, $log['email']);
            header('Location: index.php');
            die();
        }
        $errors['password'] = 'Вы ввели неверный пароль!';
    }
}

$pageContent = includeTemplate('user_login.php', [
    'categories' => $categories,
    'errors' => $errors,
]);

$layoutContent = includeTemplate('layout.php', [
    'pageTitle' => 'Вход',
    'pageContent' => $pageContent,
    'categories' => $categories,
]);

echo $layoutContent;
