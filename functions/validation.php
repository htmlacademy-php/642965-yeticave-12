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
 * @param int $bidStep шаг ставки
 * @return string|null возвращает либо строку с ошибкой либо ничего.
 */
function validateStep(string $cost, int $price, int $bidStep): ?string
{
    if (!ctype_digit($cost) || $cost <= 0) {
        return "Введите целое положительное число";
    }
    if ($cost < ($price + $bidStep)) {
        $newPrice = $price + $bidStep;
        return "Значение должно быть больше или равно: $newPrice";
    }
    return null;
}

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД' и отсутствие ошибок
 * Дата окончания лота должна быть больше текущей хотя бы на 1 сутки
 *
 * @param string $value дата в виде строки
 * @param int $minDays Колличество дней прибавляемое к текущей дате
 * @return string сравнивает дату окончания с (текущей датой + $min_days) и возвращает строку с сообщением об ошибке
 */
function dateCompleteValid(string $value, int $minDays): ?string
{
    $dtComplete = DateTime::createFromFormat('Y-m-d', $value);
    if ($dtComplete == false || array_sum(DateTime::getLastErrors()) !== 0) {
        return "Введите дату в правильном формате";
    }

    $minDate = new DateTime('+' . $minDays . ' day');
    if ($dtComplete < $minDate) {
        return "Увеличьте дату завершения торгов";
    }

    return null;
}

/**
 * Проверяет расширение файла и MIME тип согласно заданным условиям
 *
 * @param string $fileName имя файла для сравнения расширения
 * @param string $tmpName 'tmp' - имя файла для сравнения MIME типа
 * @return string в зависимости от проверки возвращает строку с сообщением об ошибке
 */
function validateFile(string $fileName, string $tmpName): ?string
{
    if (empty($fileName)) {
        return 'Вы не загрузили файл изображения';
    }

    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowed = ['png', 'jpg', 'jpeg'];
    if (!in_array($ext, $allowed)) {
        return 'Загрузите картинку с расширением JPEG или PNG';
    }

    $fileType = mime_content_type($tmpName);
    if ($fileType !== "image/jpeg" and $fileType !== "image/png") {
        return 'Неверный тип файла!';
    }

    return null;
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
