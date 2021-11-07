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
        'name' => function ($value) {
            return validateFilled($value);
        },
        'message' => function ($value) {
            return isCorrectLength($value, 20, 200);
        },
    ];

    $reg = filter_input_array(INPUT_POST, ['email' => FILTER_DEFAULT, 'password' => FILTER_DEFAULT, 'name' => FILTER_DEFAULT,
        'message' => FILTER_DEFAULT], true);

    foreach ($reg as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
    }

    $errors['email'] = $errors['email'] ?? validateRegEmail($connection, $reg['email']);
    $errors = array_filter($errors);

    if (!count($errors)) {
        $pass = password_hash($reg['password'], PASSWORD_DEFAULT);

        //Добавляет в БД нового пользователя
        inUsers($connection, $reg['email'], $pass, $reg['name'], $reg['message']);

        header('Location: login.php');
        die;
    }
}

$page_content = include_template('user_reg.php', [
    'categories' => $categories,
    'errors' => $errors,
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Регистрация пользователя',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
