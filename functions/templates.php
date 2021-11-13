<?php
/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 *
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template(string $name, array $data = []): string
{
    $name = __DIR__ . '/../templates/' . $name;

    ob_start();
    extract($data);
    require $name;

    return ob_get_clean();
}

/**
 * Функция округления и форматирования числа
 *
 * @param float $price цена в виде десятичного числа
 * @return string отформатированная, округленная цена со знаком рубля.
 */
function price_format(float $price): string
{
    $price = ceil($price);
    $price = number_format($price,0,'',' ') . " ₽";
    return $price;
}

/**
 * Экранирует двойные и одинарные кавычки
 *
 * @param string $str входящая строка
 * @return string возвращает преобразованную строку
 */
function esc(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * Функция возвращает разницу во времени между будущим и настоящим [часы, минуты]
 *
 * @param string $future_date
 * @return array возвращает массив с остатком времени в виде [часы, минуты]
 */
function difference_date(string $future_date): array
{
    date_default_timezone_set("Europe/Moscow");
    $time_expires_sec = strtotime($future_date) - time();

    $hours = floor($time_expires_sec / 3600); //Колличество часов до нужного события
    $minutes = floor(($time_expires_sec % 3600) / 60); //Колличество минут до нужного события

    $hours = ($hours < 0) ? "00" : str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = ($minutes < 0) ? "00" : str_pad($minutes, 2, "0", STR_PAD_LEFT);

    return [$hours, $minutes];
}

/**
 * Функция для получения значений из запроса и подстановки их в шаблон
 *
 * @param string $name имя поля в запросе
 * @return string возвращаемый либо значение поля либо ничего
 */
function getPostVal(string $name): string {
    return $_REQUEST[$name] ?? "";
}

/**
 * функция для отладки
 * выводит в шаблон значения переменных
 *
 * @param mixed $data переменная, значение которой выведится в шаблон.
 */
function pr($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
