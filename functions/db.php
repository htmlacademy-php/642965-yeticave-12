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
             FROM lots l, categories c WHERE category_id = c.id AND dt_complete > NOW() ORDER BY dt_create DESC LIMIT 6';

    $result_lots = $link->query($sql_lots);
    return $result_lots->fetch_all(MYSQLI_ASSOC);
}

/**
 * получает колличество строк из таблицы согласно поисковому запросу
 *
 * @param mysqli $link ресурс соединения
 * @param string $search поисковый запрос
 * @return int возвращает колличество строк
 */
function getNumRows(mysqli $link, string $search)
{
    $sql_lots = "SELECT name, description FROM lots WHERE dt_complete > NOW() AND MATCH(name, description) AGAINST (?)";

    $stmt = $link->prepare($sql_lots);
    $stmt->bind_param('s', $search);
    $stmt->execute();
    $res_lots = $stmt->get_result();

    return $res_lots->num_rows;
}

/**
 * получает список лотов согласно поисковому запросу
 * и согласно параметрам для отображения на странице
 *
 * @param mysqli $link ресурс соединения
 * @param string $search поисковый запрос
 * @param int $limit кол-во отображаемых лотов на странице
 * @param int $offset смещение
 * @return array возвращает массив с данными
 */
function getSearchLots(mysqli $link, string $search, int $limit, int $offset): array
{
    $sql_lots = "SELECT l.id, l.name AS lot_name, price_start, image, c.name AS cat_name, dt_complete
             FROM lots l, categories c WHERE category_id = c.id AND dt_complete > NOW() AND MATCH(l.name, description) AGAINST (?) ORDER BY dt_create LIMIT ? OFFSET ?";

    $stmt = $link->prepare($sql_lots);
    $stmt->bind_param('sii', $search, $limit, $offset);
    $stmt->execute();
    $res_lots = $stmt->get_result();

    return $res_lots->fetch_all(MYSQLI_ASSOC);
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
    $sql_lot = 'SELECT l.id, l.name AS lot_name, image, c.name AS cat_name, description, price_start, dt_complete, bid_step, u.name AS user_name
            FROM lots l JOIN users u ON user_id = u.id JOIN categories c ON category_id = c.id WHERE l.id = ?';

    $stmt = $link->prepare($sql_lot);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result_lot = $stmt->get_result();

    return $result_lot->fetch_assoc();
}

/**
 * Добавляет новый лот в БД
 *
 * @param mysqli $link ресурс соединения
 * @param int $id идентификатор авторизованного пользователя
 * @param string $name название лота
 * @param int $cat_id идентификатор категории
 * @param string $message описание лота
 * @param int $rate начальная цена
 * @param int $step шаг ставки
 * @param string $date дата окончания торгов
 * @param string $path путь к изображению лота
 */
function inLots(mysqli $link, int $id, string $name, int $cat_id, string $message, int $rate, int $step, string $date, string $path)
{
    $sql_ins_lot = 'INSERT INTO lots SET dt_create = NOW(), user_id = ?, name = ?, category_id = ?, description = ?, price_start = ?, bid_step = ?, dt_complete = ?, image = ?';
    $stmt = $link->prepare($sql_ins_lot);
    $stmt->bind_param('isisiiss', $id, $name, $cat_id, $message, $rate, $step, $date, $path);
    $stmt->execute();
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
 * Проверяет email для регистрации пользователя
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
 * Добавляет данные пользователя в БД
 *
 * @param mysqli $link ресурс соединения
 * @param string $email email пользователя
 * @param string $pass 'хэш' пароля пользователя
 * @param string $name имя пользователя
 * @param string $message контактные данные
 */
function inUsers(mysqli $link, string $email, string $pass, string $name, string $message)
{
    $sql_reg = 'INSERT INTO users SET dt_create = NOW(), email = ?, password = ?, name = ?, contacts = ?';
    $stmt = $link->prepare($sql_reg);
    $stmt->bind_param('ssss', $email, $pass, $name, $message);
    $stmt->execute();
}

/**
 * Проверяет email для аутентификации пользователя
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
