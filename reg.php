<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
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

    foreach ($_POST as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
    }

    if (empty($errors['email'])) {
        $errors['email'] = validateRegEmail($con);
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('user_reg.php', [
            'categories' => $categories,
            'errors' => $errors,
        ]);
    }
    else {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql_reg = 'INSERT INTO users SET dt_registration = NOW(), email = ?, password = ?, first_name = ?, contacts = ?';
        $stmt = $con->prepare($sql_reg);
        $stmt->bind_param('ssss', $_POST['email'], $pass, $_POST['name'], $_POST['message']);
        $stmt->execute();

        header('Location: login.php');
        die;
    }
}
else {
    $page_content = include_template('user_reg.php', [
        'categories' => $categories,
    ]);
}

$layout_content = include_template('layout.php', [
    'page_title' => 'Регистрация пользователя',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
