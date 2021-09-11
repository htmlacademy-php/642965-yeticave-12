<?php
// Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

//Функция округления и форматирования числа
function price_format($price) {
    $price = ceil($price);
    $price = number_format($price,0,'',' ') . " ₽";
    return $price;
}

//фильтрует содержимое и возвращает очищенную строку
function esc($str) {
    $text = htmlspecialchars($str);
    return $text;
}
