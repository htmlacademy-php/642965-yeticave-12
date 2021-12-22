<?php
/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML документ
 *
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function includeTemplate(string $name, array $data = []): string
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
function priceFormat(float $price): string
{
    $price = ceil($price);
    $price = number_format($price, 0, '', ' ') . " ₽";
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
 * @param string $future_date строка с датой
 * @return array возвращает массив с остатком времени в виде [часы, минуты]
 */
function differenceDate(string $future_date): array
{
    $timeExpiresSec = strtotime($future_date) - time();

    $hours = floor($timeExpiresSec / 3600); //Колличество часов до нужного события
    $minutes = floor(($timeExpiresSec % 3600) / 60); //Колличество минут до нужного события

    $hours = ($hours < 0) ? "00" : str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = ($minutes < 0) ? "00" : str_pad($minutes, 2, "0", STR_PAD_LEFT);

    return [$hours, $minutes];
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     getNounPluralForm(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function getNounPluralForm(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * из настоящего времени вычитает дату от прошедшего события
 * полученное время разбивает на часы и минуты
 * в зависимости от условия выводит дату в человеческом формате
 *
 * @param string $date строка с датой
 * @return string возвращает отформатированную строку с датой
 */
function pastDate(string $date): string
{
    $time = time() - strtotime($date);

    $hours = floor($time / 3600); //Колличество часов до нужного события
    $minutes = floor(($time % 3600) / 60); //Колличество минут до нужного события

    if ($hours < 1) {
        return $minutes . ' ' . getNounPluralForm($minutes, 'минута', 'минуты', 'минут') . ' ' . 'назад';
    }
    if (($hours >= 1) && ($hours < 24)) {
        return $hours . ' ' . getNounPluralForm($hours, 'час', 'часа', 'часов') . ' ' . 'назад';
    }

    $past_date = date_create($date);
    return date_format($past_date, 'd.m.y в H:i');
}

/**
 * Функция для получения значений из запроса и подстановки их в шаблон
 *
 * @param string $name имя поля в запросе
 * @return string возвращаемый либо значение поля либо ничего
 */
function getPostVal(string $name): string
{
    return $_REQUEST[$name] ?? "";
}

/**
 * Если пользователь авторизован, присваивает переменой значение его Id
 * Если не авторизован, переадрессовывает на страницу входа.
 * @return int|null возвращает значение Id пользователя.
 */
function getUserIdFromSession(): ?int
{
    $userId = $_SESSION['id'] ?? null;

    if (empty($userId)) {
        header('Location: login.php');
        die();
    }

    return $userId;
}

/**
 * функция для отладки
 * выводит в шаблон значения переменных
 *
 * @param mixed $data переменная, значение которой выведется в шаблон.
 */
function pr($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

/**
 * подставляет в шаблон строку с названием класса.
 * @param string $hours строка содержащая время (час)
 * @param string $minutes строка содержащая время (минуты)
 * @return string возвращает либо строку с названием класса либо пустую
 */
function timerClass(string $hours, string $minutes): string
{
    if (($hours < 1) && ($minutes > 0)) {
        return "timer--finishing";
    }
    if (($hours == 0) && ($minutes == 0)) {
        return "timer--end";
    }

    return "";
}

/**
 * подставляет в шаблон либо строку с сообщением либо со временем.
 * @param string $hours строка содержащая время (час)
 * @param string $minutes строка содержащая время (минуты)
 * @return string возвращает строку с сообщением либо время hh:mm
 */
function timerResult(string $hours, string $minutes): string
{
    if (($hours == 0) && ($minutes == 0)) {
        return "Торги окончены";
    }

    return "$hours:$minutes";
}

/**
 * Выводит шаблон страницы с ошибкой
 * @param array $categories список категорий выводится в шапке и подвале шаблона.
 */
function template404(array $categories)
{
    $pageContent = includeTemplate('404.php', [
        'categories' => $categories,
    ]);

    $layoutContent = includeTemplate('layout.php', [
        'pageTitle' => 'Ошибка 404',
        'pageContent' => $pageContent,
        'categories' => $categories,
    ]);

    echo $layoutContent;
}
