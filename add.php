<?php
require __DIR__ . '/init.php'; //Файл инициализации приложения

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat_id = array_column($categories, 'id');
    $errors = [];
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
            return is_date_valid($value);
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

    $errors['file'] = validateFile();
    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('add_lot.php', [
            'categories' => $categories,
            'errors' => $errors,
        ]);
    }
    else {
        move_uploaded_file($_FILES['file_img']['tmp_name'], 'uploads/' . $_FILES['file_img']['name']);
        $lot['path'] = 'uploads/' . $_FILES['file_img']['name'];

        $sql_ins_lot = 'INSERT INTO lots SET dt_create = NOW(), user_id = 9, name_lot = ?, category_id = ?, description = ?, price_start = ?, bid_step = ?, dt_complete = ?, image = ?';
        $stmt = $con->prepare($sql_ins_lot);
        $stmt->bind_param('sisdiss', $lot['lot-name'], $lot['category'], $lot['message'], $lot['lot-rate'], $lot['lot-step'], $lot['lot-date'], $lot['path']);
        $stmt->execute();

        $lot_id = mysqli_insert_id($con);
        header('Location: lot.php?id=' . $lot_id);
        die;
    }
}
else {
    $page_content = include_template('add_lot.php', [
        'categories' => $categories,
    ]);
}

$layout_content = include_template('layout.php', [
    'page_title' => 'Добавление лота',
    'page_content' => $page_content,
    'categories' => $categories,
]);

echo $layout_content;
