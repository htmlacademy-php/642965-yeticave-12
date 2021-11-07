<?php
session_start();

if (empty($_SESSION)) {
    header('location: reg.php');
    setcookie('location','add.php',time()+3600);
    die;
}

require __DIR__ . '/init.php'; //Файл инициализации приложения
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat_id = array_column($categories, 'id');
    $rules = [
        'lot-name' => function ($value) {
            return validateFilled($value);
        },
        'category' => function ($value) use ($cat_id) {
            return validateCategory($value, $cat_id);
        },
        'message' => function ($value) {
            return isCorrectLength($value, 20, 200);
        },
        'lot-rate' => function ($value) {
            return validateRate($value);
        },
        'lot-step' => function ($value) {
            return validateStep($value);
        },
        'lot-date' => function ($value) {
            return dateCompleteValid($value, 1);
        },
    ];

    $lot = filter_input_array(INPUT_POST, ['lot-name' => FILTER_DEFAULT, 'category' => FILTER_DEFAULT, 'message' => FILTER_DEFAULT,
        'lot-rate' => FILTER_DEFAULT, 'lot-step' => FILTER_DEFAULT, 'lot-date' => FILTER_DEFAULT], true);

    foreach ($lot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }
    }

    $errors['file'] = validateFile($_FILES['file_img']['name'], $_FILES['file_img']['tmp_name']);
    $errors = array_filter($errors);

    if (!count($errors)) {
        move_uploaded_file($_FILES['file_img']['tmp_name'], 'uploads/' . $_FILES['file_img']['name']);
        $lot['path'] = 'uploads/' . $_FILES['file_img']['name'];

        //Добавляет в БД новый лот
        inLots($connection, $_SESSION['id'], $lot['lot-name'], $lot['category'], $lot['message'], $lot['lot-rate'], $lot['lot-step'], $lot['lot-date'], $lot['path']);

        $lot_id = mysqli_insert_id($connection);
        header('Location: lot.php?id=' . $lot_id);
        die;
    }
}

$page_content = include_template('add_lot.php', [
    'categories' => $categories,
    'errors' => $errors,
]);

$layout_content = include_template('layout.php', [
    'page_title' => 'Добавление лота',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
