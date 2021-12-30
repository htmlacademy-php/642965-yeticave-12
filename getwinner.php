<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require __DIR__ . '/vendor/autoload.php';

// Получаем массив с истекшими лотами, где были сделаны ставки и где победитель еще не определен
// Передается id, имя лота, последняя максимальная ставка
$completeLots = getCompleteLots($connection);

if (!empty($completeLots)) {

    // Используем Symfony Mailer для отправки сообщений победителям
    $transport = Transport::fromDsn('smtp://fd2c6cd72bf938:6cb1408e5976ed@smtp.mailtrap.io:2525'); // Конфигурация траспорта
    $message = new Email(); // Объект для подготовки сообщения
    $mailer = new Mailer($transport); // Объект для отправки сообщения

    foreach ($completeLots as $completeLot) {
        // Получаем id автора последней максимальной ставки
        $userWinner = getUserWinner($connection,  $completeLot['lotId'], $completeLot['maxPrice']);

        // Записываем id победителя в таблицу
        inLotsUserWinner($connection, $userWinner['userId'], $completeLot['lotId']);

        // Получаем имя победителя и его электронную почту для подстановки в шаблон сообщения
        $contactslWinner = getContactsUserWinner($connection, $userWinner['userId']);

        // Подключаем шаблон с текстом письма
        $text_email = includeTemplate('text_email.php', [
            'completeLot' => $completeLot,
            'contactslWinner' => $contactslWinner,
            'config' => $config,
        ]);

        // Отправка сообщения победителю
        $message->to($contactslWinner['userEmail']);
        $message->from('keks@phpdemo.ru');
        $message->subject('Ваша ставка победила');
        $message->html($text_email);
        $mailer->send($message);
    }
}
