<?php
/** @var mysqli $connection */
/** @var array $config */

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/functions/mail.php'; // подключение функций для работы с почтой.

$email = $config['email'];
$baseUrl = $config['baseUrl'];

// Получаем массив с истекшими лотами, где были сделаны ставки и где победитель еще не определен
// Передается id, имя лота, последняя максимальная ставка
$completeLots = getCompleteLots($connection);

if (!empty($completeLots)) {

    // Используем Symfony Mailer для отправки сообщений победителям
    $transport = Transport::fromDsn('smtp://' . $email['user'] . ':' . $email['password'] . '@' . $email['smtp'] . ':' . $email['port']); // Конфигурация траспорта
    $mailer = new Mailer($transport); // Объект для отправки сообщения

    foreach ($completeLots as $completeLot) {
        // Получаем id автора последней максимальной ставки
        $userWinner = getUserWinner($connection, $completeLot['lotId'], $completeLot['maxPrice']);

        // Записываем id победителя в таблицу
        inLotsUserWinner($connection, $userWinner['userId'], $completeLot['lotId']);

        // Получаем имя победителя и его электронную почту для подстановки в шаблон сообщения
        $contactslWinner = getContactsUserWinner($connection, $userWinner['userId']);

        // Отправка сообщения победителю
        sendMailToWinner($mailer, $contactslWinner, $email['from'], $completeLot, $baseUrl);
    }
}
