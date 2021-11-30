<?php
/**
 * Проверяет заполненость поля
 *
 * @param string $value проверяемое значение
 * @return string|null возвращает строку с ошибкой или ничего
 */
function validateFilled(string $value): ?string
{
    if (empty($value)) {
        return "Заполните пожалуйста это поле";
    }
    return null;
}

/**
 * Проверяет длину поля
 *
 * @param string $value проверяемое значение
 * @param int $min минимальная длина
 * @param int $max максимальная длина
 * @return string|null возвращает строку с ошибкой или ничего
 */
function isCorrectLength(string $value, int $min, int $max): ?string
{
    $len = strlen($value);

    if ($len < $min or $len > $max) {
        return "Длина поля от $min до $max символов";
    }
    return null;
}

/**
 * Проверяет значение категории полученное из формы
 * на соответствие категории из БД
 *
 * @param string $value сравниваемое значение категории
 * @param array $category_list список категорий из БД
 * @return string|null возвращает строку с ошибкой или ничего
 */
function validateCategory(string $value, array $category_list): ?string
{
    if (!in_array($value, $category_list)) {
        return "Указана несуществующая категория";
    }
    return null;
}

/**
 * Проверяемое значене должно быть числом и больше нуля
 *
 * @param string $value проверяемое значение
 * @return string|null возвращает строку с ошибкой или ничего
 */
function validateRate(string $value): ?string
{
    if (!is_numeric($value) || $value <= 0) {
        return "Введите число больше 0";
    }
    return null;
}

/**
 * Проверяемое значене должно быть целым числом и больше нуля
 *
 * @param string $value проверяемое значение
 * @return string|null возвращает строку с ошибкой или ничего
 */
function validateBidStep(string $value): ?string
{
    if (!ctype_digit($value) || $value <= 0) {
        return "Введите целое число больше 0";
    }
    return null;
}

/**
 * Проверяет число (ставку) на заданные условия
 * число должно быть целым и положительным
 * число должно быть больше или равно предыдущей цене плюс шаг ставки
 * @param string $cost число (ставка), которая проверяется
 * @param int $price текущая цена
 * @param int $bid_step шаг ставки
 * @return string|null возвращает либо строку с ошибкой либо ничего.
 */
function validateStep(string $cost, int $price, int $bid_step): ?string
{
    if (!ctype_digit($cost) || $cost <= 0) {
        return "Введите целое положительное число";
    }
    if ($cost < ($price + $bid_step)) {
        $new_price = $price + $bid_step;
        return "Значение должно быть больше или равно: $new_price";
    }
    return null;
}

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД' и отсутствие ошибок
 * Дата окончания лота должна быть больше текущей хотя бы на 1 сутки
 *
 * @param string $value дата в виде строки
 * @param int $min_days Колличество дней прибавляемое к текущей дате
 * @return string сравнивает дату окончания с (текущей датой + $min_days) и возвращает строку с сообщением об ошибке
 */
function dateCompleteValid(string $value, int $min_days): ?string
{
    $dt_complete = DateTime::createFromFormat('Y-m-d', $value);
    if ($dt_complete !== false && array_sum(DateTime::getLastErrors()) === 0) {
        $min_date = new DateTime('+' . $min_days . ' day');
        if ($dt_complete < $min_date) {
            return "Увеличьте дату завершения торгов";
        }
        return null;
    }
    else {
        return "Введите дату в правильном формате";
    }
}

/**
 * Проверяет расширение файла и MIME тип согласно заданным условиям
 *
 * @param string $file_name имя файла для сравнения расширения
 * @param string $tmp_name 'tmp' - имя файла для сравнения MIME типа
 * @return string в зависимости от проверки возвращает строку с сообщением об ошибке
 */
function validateFile(string $file_name, string $tmp_name): ?string
{
    if (!empty($file_name)) {
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed = ['png', 'jpg', 'jpeg'];

        if (in_array($ext, $allowed)) {
            $file_type = mime_content_type($tmp_name);

            if ($file_type !== "image/jpeg" and $file_type !== "image/png") {
                return 'Неверный тип файла!';
            }
            return null;
        }
        else {
            return 'Загрузите картинку с расширением JPEG или PNG';
        }
    }
    else {
        return 'Вы не загрузили файл изображения';
    }
}

/**
 * Проверяет email на соответствие заданному фильтру
 *
 * @param string $value email для проверки
 * @return string если email не прошел проверку возвращает ошибку
 */
function validateEmail(string $value): ?string
{
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return 'Введите корректный E-mail';
    }
    return null;
}
