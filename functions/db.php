<?php
/**
 * Создает ресурс соединения с БД.
 *
 * @param array $db_data параметры подключения из файла config.php
 * @return mysqli возвращает ресурс соединения.
 */
function dbConnect(array $db_data): mysqli
{
    $connection = new mysqli($db_data['host'], $db_data['username'], $db_data['password'], $db_data['dbname']);
    $connection->set_charset($db_data['charset']);

    return $connection;
}

/**
 * Получает список категорий
 *
 * @param mysqli $link ресурс соединения
 * @return array возвращает массив со списком категорий
 */
function getCategories(mysqli $link): array
{
    $sql_categories = 'SELECT id, name AS cat_name, symbol FROM categories';
    $result_categories = $link->query($sql_categories);

    return $result_categories->fetch_all(MYSQLI_ASSOC);
}

/**
 * получает список лотов по которым торги еще не завершились.
 *
 * @param mysqli $link Ресурс соединения
 * @return array результат в виде массива
 */
function getLots(mysqli $link): array
{
    $sql_lots = 'SELECT l.id, l.name AS lot_name, price_start, image, c.name AS cat_name, dt_complete
             FROM lots l, categories c WHERE category_id = c.id AND dt_complete > NOW() ORDER BY dt_create DESC';

    $result_lots = $link->query($sql_lots);
    return $result_lots->fetch_all(MYSQLI_ASSOC);
}

/**
 * Получает информацию о лоте по его ID.
 *
 * @param mysqli $link Ресурс соединения
 * @param int $id идентификатор пользователя
 * @return array результат в виде массива
 */
function getLotID(mysqli $link, int $id): array
{
    $sql_lot = 'SELECT l.id, l.name AS lot_name, image, c.name AS cat_name, description, price_start, dt_complete, bid_step
            FROM lots l JOIN categories c ON category_id = c.id WHERE l.id = ?';

    $stmt = $link->prepare($sql_lot);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result_lot = $stmt->get_result();

    return $result_lot->fetch_assoc();
}

/**
 * Проверяет существование пользователя по его email
 *
 * @param mysqli $link ресурс соединения с бд
 * @param string $email email для проверки
 * @return bool возвращает true, если пользователь найден
 */
function existUserByEmail(mysqli $link, string $email): bool
{
    $sql = 'SELECT id FROM users WHERE email = ?';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) > 0) {
        return true;
    }
    return false;
}

/**
 * Функция для регистрации пользователя
 *
 * @param mysqli $link ресурс соединения с базой данных
 * @param string $email email для проверки
 * @return string если пользователь с таким email уже зарегистрирован, возвращает ошибку
 */
function validateRegEmail(mysqli $link, string $email): ?string
{
    if (existUserByEmail($link, $email)) {
        return 'Пользователь с этим email уже зарегистирован';
    }
    return null;
}

/**
 * Функция для аутентификации пользователя
 *
 * @param mysqli $link ресурс соединения с базой данных
 * @param string $email email для проверки
 * @return string если пользователь с таким email не найден, возвращает ошибку
 */
function validateLogEmail(mysqli $link, string $email): ?string
{
    if (!existUserByEmail($link, $email)) {
        return 'Пользователь с таким email не найден';
    }
    return null;
}

/**
 * Получает 'хэш' пароля юзера из бд.
 *
 * @param mysqli $link ресурс соединения с бд
 * @param string $email значение 'email' из формы входа.
 * @return string возвращает 'хэш' пароля из бд.
 */
function userPassword(mysqli $link, string $email): string
{
    $sql_pass = 'SELECT password FROM users WHERE email=?';
    $stmt = $link->prepare($sql_pass);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $db_pass = $result->fetch_assoc();

    return $db_pass['password'];
}

/**
 * Получает имя и id пользователя прошедшего аутентификацию
 *
 * @param mysqli $link ресурс соединения с бд
 * @param string $email значение 'email' из формы входа.
 * @return array возвращает массив с данными пользователя
 */
function UserID(mysqli $link, string $email): array
{
    $sql = 'SELECT id, name FROM users WHERE email = ?';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $result_id = $res->fetch_assoc();

    return $result_id;
}
