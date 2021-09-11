<?php
// Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
function include_template($name, array $data = []) {
    $name = __DIR__.'templates/' . $name;

    ob_start();
    extract($data);
    require $name;

    return ob_get_clean();
}

//Функция округления и форматирования числа
function price_format($price) {
    $price = ceil($price);
    $price = number_format($price,0,'',' ') . " ₽";
    return $price;
}

//фильтрует содержимое и возвращает очищенную строку
function esc($str) {
    return $text = htmlspecialchars($str, ENT_QUOTES);
}
