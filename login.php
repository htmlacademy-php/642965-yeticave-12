<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения
$errors = [];

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

            session_start();
            $_SESSION = UserID($connection, $log['email']);

            if (isset($_COOKIE['location'])) {
                setcookie('location','',time()-10000);
                header('Location:'. $_COOKIE['location']);
            }
            else {
                header('Location: index.php');
            }
            die();
        }
        else {
            $errors['password'] = 'Вы ввели неверный пароль!';
        }
    }
}

$page_content = include_template('user_login.php', [
    'categories' => $categories,
    'errors' => $errors,
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Вход',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
