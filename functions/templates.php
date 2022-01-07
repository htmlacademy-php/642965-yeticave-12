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
 * Функция возвращает разницу между датой окончания лота и настоящим временем
 * в удобочитаемом формате [часы, минуты]
 *
 * @param string $dateCompleteLot строка с датой окончания лота
 * @return array возвращает массив с остатком времени в виде [часы, минуты]
 */
function differenceDate(string $dateCompleteLot): array
{
    $timeExpiresSec = strtotime($dateCompleteLot) - time();

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
 * Из настоящего времени вычитает дату создания лота
 * полученное время разбивает на часы и минуты
 * в зависимости от результата выводит дату в удобочитаемом формате
 *
 * @param string $dateCreateLot строка с датой создания лота
 * @return string возвращает отформатированную строку с датой
 */
function pastDate(string $dateCreateLot): string
{
    $time = time() - strtotime($dateCreateLot);

    $hours = floor($time / 3600); //Колличество часов до нужного события
    $minutes = floor(($time % 3600) / 60); //Колличество минут до нужного события

    if ($hours < 1) {
        return $minutes . ' ' . getNounPluralForm($minutes, 'минута', 'минуты', 'минут') . ' ' . 'назад';
    }
    if (($hours >= 1) && ($hours < 24)) {
        return $hours . ' ' . getNounPluralForm($hours, 'час', 'часа', 'часов') . ' ' . 'назад';
    }

    $past_date = date_create($dateCreateLot);
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
 * Функция для отладки
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
 * Функция возвращает разницу между датой окончания лота и настоящим временем
 * @param string $dateCompleteLot строка с датой окончания лота
 * @return int возвращает целое число больше или меньше 0
 */
function diffDateComplete(string $dateCompleteLot): int
{
    return strtotime($dateCompleteLot) - time();
}

/**
 * Функция подставляет полученную разницу во времени диапазон от 1 до 59
 * @param string $dateCompleteLot строка с датой окончания лота
 * @return bool возвращает true если время находится в диапазоне и false есди нет
 */
function lastMinute(string $dateCompleteLot): bool
{
    if ((diffDateComplete($dateCompleteLot) > 0) && (diffDateComplete($dateCompleteLot) < 60)) {
        return true;
    }
    return false;
}

/**
 * подставляет в шаблон строку с названием класса.
 * @param string $dateCompleteLot строка с датой окончания лота
 * @param int $userSessionId идентификатор авторизованного пользователя
 * @param int $userWinnerId идентификатор юзера ставка которого победила
 * @return string возвращает либо строку с названием класса либо пустую
 */
function ratesItemClass(string $dateCompleteLot, int $userSessionId, ?int $userWinnerId): string
{
    if ($userSessionId === $userWinnerId) {
        return "rates__item--win";
    }
    if (diffDateComplete($dateCompleteLot) < 0) {
        return "rates__item--end";
    }
    return "";
}

/**
 * Подставляет в шаблон строку с названием класса.
 * @param string $dateCompleteLot строка с датой окончания лота
 * @param int $userSessionId идентификатор авторизованного пользователя
 * @param int $userWinnerId идентификатор юзера ставка которого победила
 * @return string возвращает либо строку с названием класса либо пустую
 */
function timerClass(string $dateCompleteLot, int $userSessionId, ?int $userWinnerId): string
{
    if ($userSessionId === $userWinnerId) {
        return "timer--win";
    }
    if ((diffDateComplete($dateCompleteLot) < 3600) && (diffDateComplete($dateCompleteLot) > 0)) {
        return "timer--finishing";
    }
    if (diffDateComplete($dateCompleteLot) < 0) {
        return "timer--end";
    }
    return "";
}

/**
 * подставляет в шаблон либо строку с сообщением либо со временем.
 * @param string $dateCompleteLot строка с датой окончания лота
 * @param int $userSessionId идентификатор авторизованного пользователя
 * @param int $userWinnerId идентификатор юзера ставка которого победила
 * @return string возвращает строку с сообщением либо время hh:mm
 */
function timerResult(string $dateCompleteLot, int $userSessionId, ?int $userWinnerId): string
{
    if ($userSessionId === $userWinnerId) {
        return "Ставка выиграла";
    }
    if (diffDateComplete($dateCompleteLot) < 0) {
        return "Торги окончены";
    }
    list ($hours, $minutes) = differenceDate($dateCompleteLot);
    return "{$hours}:{$minutes}";
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
