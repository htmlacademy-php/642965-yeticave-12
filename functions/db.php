<?php
/**
 * Создает ресурс соединения с БД.
 *
 * @param array $dbData параметры подключения из файла config.php
 * @return mysqli возвращает ресурс соединения.
 */
function dbConnect(array $dbData): mysqli
{
    $connection = new mysqli($dbData['host'], $dbData['username'], $dbData['password'], $dbData['dbname']);
    $connection->set_charset($dbData['charset']);

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
    $sql = 'SELECT id, name AS cat_name, symbol FROM categories';
    $result = $link->query($sql);

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * получает список лотов для главной страницы по которым торги еще не завершились.
 *
 * @param mysqli $link Ресурс соединения
 * @param int $mainLotsQuantity кол-во отображаемых лотов на странице
 * @return array результат в виде массива
 */
function getLots(mysqli $link, int $mainLotsQuantity): array
{
    $sql = "SELECT l.id, l.name AS lot_name, price_start, image, c.name AS cat_name, dt_complete
            FROM lots l, categories c WHERE category_id = c.id AND dt_complete > NOW() ORDER BY dt_create DESC LIMIT ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $mainLotsQuantity);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * получает колличество строк из таблицы согласно поисковому запросу
 *
 * @param mysqli $link ресурс соединения
 * @param string $search поисковый запрос
 * @return int возвращает колличество строк
 */
function numRowsSearchLots(mysqli $link, string $search): int
{
    $sql = "SELECT name, description FROM lots WHERE dt_complete > NOW() AND MATCH(name, description) AGAINST (?)";

    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $search);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows;
}

/**
 * получает список лотов согласно поисковому запросу
 * и согласно параметрам для отображения на странице
 *
 * @param mysqli $link ресурс соединения
 * @param string $search поисковый запрос
 * @param int $categoryLotsPerPage кол-во отображаемых лотов на странице
 * @param int $offset смещение
 * @return array возвращает массив с данными
 */
function getSearchLots(mysqli $link, string $search, int $categoryLotsPerPage, int $offset): array
{
    $sql = "SELECT l.id, l.name AS lot_name, price_start, image, c.name AS cat_name, dt_complete
            FROM lots l, categories c WHERE category_id = c.id AND MATCH(l.name, description) AGAINST (?) ORDER BY dt_create DESC LIMIT ? OFFSET ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param('sii', $search, $categoryLotsPerPage, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Получает информацию о лоте по его ID.
 *
 * @param mysqli $link Ресурс соединения
 * @param int $id идентификатор пользователя
 * @return array результат в виде массива
 */
function getLotID(mysqli $link, int $id): ?array
{
    $sql = "SELECT l.id, l.name AS lot_name, image, c.name AS cat_name, description, price_start, dt_complete, bid_step, u.name AS user_name, user_id
            FROM lots l JOIN users u ON user_id = u.id JOIN categories c ON category_id = c.id WHERE l.id = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

/**
 * получает колличество строк из таблицы согласно сортировке по категории
 *
 * @param mysqli $link ресурс соединения
 * @param string $category категория для сортировки
 * @return int возвращает колличество строк
 */
function numRowsLotsCategory(mysqli $link, string $category): int
{
    $sql = "SELECT l.id, l.name FROM lots l, categories c WHERE l.category_id = c.id AND c.name = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows;
}

/**
 * получает список лотов отсортированный по категориям
 *
 * @param mysqli $link ресурс соединения с БД
 * @param string $category категория для сортировки
 * @param int $categoryLotsPerPage кол-во отображаемых лотов на странице
 * @param int $offset смещение
 * @return array результат в виде массива
 */
function getLotsCategory(mysqli $link, string $category, int $categoryLotsPerPage, int $offset): array
{
    $sql = "SELECT l.id, l.name AS lot_name, image, c.name AS cat_name, price_start, dt_complete
            FROM lots l, categories c WHERE category_id = c.id AND c.name = ? ORDER BY dt_create DESC LIMIT ? OFFSET ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param('sii', $category, $categoryLotsPerPage, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Добавляет новый лот в БД
 * @param mysqli $link ресурс соединения
 * @param int $id идентификатор авторизованного пользователя
 * @param array $lot массив с данными для добавления в бд
 */
function addLots(mysqli $link, int $id, array $lot)
{
    $sql = 'INSERT INTO lots SET dt_create = NOW(), user_id = ?, name = ?, category_id = ?, description = ?, price_start = ?, bid_step = ?, dt_complete = ?, image = ?';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('isisiiss', $id, $lot['lot-name'], $lot['category'], $lot['message'], $lot['lot-rate'], $lot['lot-step'], $lot['lot-date'], $lot['path']);
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
    $sql = 'INSERT INTO users SET dt_create = NOW(), email = ?, password = ?, name = ?, contacts = ?';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('ssss', $email, $pass, $name, $message);
    $stmt->execute();
}

/**
 * Добавляет ставку в таблицу ставок
 *
 * @param mysqli $link ресурс соединения
 * @param int $cost валидная ставка, введенная пользователем в форму
 * @param int $lotId идентификатор лота
 * @param int $userId идентификатор пользователя
 */
function inBets(mysqli $link, int $cost, int $lotId, int $userId)
{
    $sql = "INSERT INTO bets SET dt_create = NOW(), price = ?, lot_id = ?, user_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('iii', $cost, $lotId, $userId);
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
    $sql = 'SELECT password FROM users WHERE email=?';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $pass = $result->fetch_assoc();

    return $pass['password'];
}

/**
 * Получает имя и id пользователя прошедшего аутентификацию
 *
 * @param mysqli $link ресурс соединения с бд
 * @param string $email значение 'email' из формы входа.
 * @return array возвращает массив с данными пользователя
 */
function userID(mysqli $link, string $email): array
{
    $sql = 'SELECT id, name FROM users WHERE email = ?';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

/**
 * Получает ставки по id лота
 * @param mysqli $link ресурс соединения
 * @param int $id идентификатор лота
 * @return array|null возвращает массив с полученными ставками
 */
function getLotBets(mysqli $link, int $id): array
{
    $sql = "SELECT b.price, b.user_id, u.name, b.dt_create FROM bets b, users u WHERE lot_id = ? AND b.user_id = u.id ORDER BY dt_create DESC";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Получает ставки сделанные пользователем по его идентификатору.
 * @param mysqli $link ресурс соединения
 * @param int $userId идентификатор пользователя
 * @return array возвращает массив с полученными ставками.
 */
function getMyBets(mysqli $link, int $userId): array
{
    $sql = "SELECT l.id, l.image, l.name AS lot_name, l.description, c.name AS cat_name, l.dt_complete, user_winner_id, MAX(b.price) AS priceMax, MAX(b.dt_create) AS dtCreate, u.name, u.contacts
            FROM lots l JOIN categories c ON l.category_id = c.id JOIN bets b ON b.lot_id = l.id JOIN users u ON u.id = l.user_id WHERE b.user_id = ? GROUP BY l.id, u.id ORDER BY dtCreate DESC";

    $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Получаем массив с истекшими лотами, где были сделаны ставки и где победитель еще не определен
 * @param mysqli $link ресурс соединения
 * @return array|null Передается id, имя лота, последняя максимальная ставка
 */
function getCompleteLots(mysqli $link): ?array
{
    $sql = "SELECT l.id AS lotId, l.name AS lotName, MAX(b.price) AS maxPrice
            FROM lots l JOIN bets b ON b.lot_id = l.id WHERE dt_complete <= NOW() AND user_winner_id IS NULL GROUP BY l.id ORDER BY l.id";
    $result = $link->query($sql);

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Получаем id автора последней максимальной ставки
 * @param mysqli $link ресурс соединения
 * @param int $lotId id отыгравшего лота
 * @param int $maxPrice последняя максимальная ставка
 * @return array возвращает id победителя
 */
function getUserWinner(mysqli $link, int $lotId, int $maxPrice): array
{
    $sql = "SELECT user_id AS userId FROM bets WHERE lot_id = ? AND price = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('ii', $lotId, $maxPrice);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

/**
 * Записываем id победителя в таблицу Lots, поле победитель
 * @param mysqli $link ресурс соединения
 * @param int $userWinner id победителя
 * @param int $lotId id лота
 */
function inLotsUserWinner(mysqli $link, int $userWinner, int $lotId)
{
    $sql = "UPDATE lots SET user_winner_id = ? WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('ii',$userWinner, $lotId);
    $stmt->execute();
}

/**
 * Получаем имя победителя и его электронную почту для подстановки в шаблон сообщения
 * @param mysqli $link ресурс соединения
 * @param int $userWinnerId id автора последней максимальной ставки
 * @return array ассоциативный массив с данными победителя
 */
function getContactsUserWinner(mysqli $link, int $userWinnerId): ?array
{
    $sql = "SELECT u.name AS userName, u.email AS userEmail FROM users u JOIN bets b ON u.id = b.user_id WHERE b.user_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $userWinnerId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}
