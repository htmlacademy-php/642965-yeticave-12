<?php
// Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
function include_template($name, array $data = []) {
    $name = __DIR__ . '/templates/' . $name;

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
    return htmlspecialchars($str, ENT_QUOTES);
}

//Функция возвращает разницу во времени между будущим и настоящим [часы, минуты]
function difference_date($future_date) {
    date_default_timezone_set("Europe/Moscow");
    $time_expires_sec = strtotime($future_date) - time();

    $hours = floor($time_expires_sec / 3600); //Колличество часов до нужного события
    $minutes = floor(($time_expires_sec % 3600) / 60); //Колличество минут до нужного события

    if ($hours < 10) {$hours = str_pad($hours, 2, "0", STR_PAD_LEFT);}
    if ($hours < 0) {$hours = "00";}

    if ($minutes < 10) {$minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);}
    if ($minutes < 0) {$minutes = "00";}

    return [$hours, $minutes]; //Массив с остатком времени
}
