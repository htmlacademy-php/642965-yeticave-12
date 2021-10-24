<?php
// Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
function include_template($name, array $data = []) {
    $name = __DIR__ . '/templates/' . $name;

    ob_start();
    extract($data);
    require $name;

    return ob_get_clean();
}

// Функция округления и форматирования числа
function price_format($price) {
    $price = ceil($price);
    $price = number_format($price,0,'',' ') . " ₽";
    return $price;
}

// фильтрует содержимое и возвращает очищенную строку
function esc($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

// Функция возвращает разницу во времени между будущим и настоящим [часы, минуты]
function difference_date($future_date) {
    date_default_timezone_set("Europe/Moscow");
    $time_expires_sec = strtotime($future_date) - time();

    $hours = floor($time_expires_sec / 3600); //Колличество часов до нужного события
    $minutes = floor(($time_expires_sec % 3600) / 60); //Колличество минут до нужного события

    $hours = ($hours < 0) ? "00" : str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = ($minutes < 0) ? "00" : str_pad($minutes, 2, "0", STR_PAD_LEFT);

    return [$hours, $minutes]; //Массив с остатком времени
}

// Функция для получения значений из POST-запроса
function getPostVal($name) {
    return $_POST[$name] ?? "";
}
// Функция для проверки заполнености
function validateFilled($value) {
    if (empty($value)) {
        return "Заполните пожалуйста это поле";
    }
}
// Функция для проверки длины
function isCorrectLength($value, $min, $max) {
    $len = strlen($value);

    if ($len < $min or $len > $max) {
        return "Длина поля от $min до $max символов";
    }
}
// Функция для проверки категории
function validateCategory($value, $category_list) {
    if (!in_array($value, $category_list)) {
        return "Указана несуществующая категория";
    }
}
// Функция для валидации ставки
function validateRate($value) {
    if (!is_numeric($value) || $value <= 0) {
        return "Введите число больше 0";
    }
}
// Функция для валидации шага ставки
function validateStep($value) {
    if (!ctype_digit($value) || $value <= 0) {
       return "Введите целое число больше 0";
    }
}
// Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД' и отсутствие ошибок
// Дата окончания лота должна быть больше текущей хотя бы на 1 сутки
function dateCompleteValid($value, $min_days) {
    $dt_complete = DateTime::createFromFormat('Y-m-d', $value);
    if ($dt_complete !== false && array_sum(DateTime::getLastErrors()) === 0) {
        $min_date = new DateTime('+' . $min_days . ' day');
        if ($dt_complete < $min_date) {
            return "Увеличьте дату завершения торгов";
        }
    }
    else {
        return "Введите дату в правильном формате";
        }
}
// Валидация файла. Проверка расширения и MIME типа.
function validateFile($file_name, $tmp_name) {
    if (!empty($file_name)) {
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed = ['png', 'jpg', 'jpeg'];

        if (in_array($ext, $allowed)) {
            $file_type = mime_content_type($tmp_name);

            if ($file_type !== "image/jpeg" and $file_type !== "image/png") {
                return 'Неверный тип файла!';
            }
        }
        else {
            return 'Загрузите картинку с расширением JPEG или PNG';
        }
    }
    else {
        return 'Вы не загрузили файл изображения';
    }
}
// Валидация email.
function validateEmail($value) {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return 'Введите корректный Email';
    }
}
// Проверяет есть ли в бд пользователи с таким email.
function validateRegEmail($link, $email) {
        $sql = 'SELECT id FROM users WHERE email = ?';
        $stmt = $link->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if (mysqli_num_rows($res) > 0) {
            return 'Пользователь с этим email уже зарегистрирован';
        }
}
