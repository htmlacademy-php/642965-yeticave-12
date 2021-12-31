<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require __DIR__ . '/vendor/autoload.php';
$email = $config['email'];
$base_url = $config['base_url'];

// Получаем массив с истекшими лотами, где были сделаны ставки и где победитель еще не определен
// Передается id, имя лота, последняя максимальная ставка
$completeLots = getCompleteLots($connection);

if (!empty($completeLots)) {

    // Используем Symfony Mailer для отправки сообщений победителям
    $transport = Transport::fromDsn('smtp://' . $email['user'] . ':' . $email['password'] . '@' . $email['smtp'] . ':' . $email['port']); // Конфигурация траспорта
    $message = new Email(); // Объект для подготовки сообщения
    $mailer = new Mailer($transport); // Объект для отправки сообщения

    foreach ($completeLots as $completeLot) {
        // Получаем id автора последней максимальной ставки
        $userWinner = getUserWinner($connection, $completeLot['lotId'], $completeLot['maxPrice']);

        // Записываем id победителя в таблицу
        inLotsUserWinner($connection, $userWinner['userId'], $completeLot['lotId']);

        // Получаем имя победителя и его электронную почту для подстановки в шаблон сообщения
        $contactslWinner = getContactsUserWinner($connection, $userWinner['userId']);

        // Отправка сообщения победителю
        sendMail($message, $mailer, $contactslWinner, $completeLot, $base_url);
    }
}
