<?php
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;

/**
 * Процесс формирования и отправки письма победителю
 * @param Mailer $mailer Объект для отправки сообщения
 * @param array $contactslWinner имя и электроная почта победителя
 * @param array $completeLot идентификатор и имя лота победителя
 * @param string $baseUrl <адрес домен> к сайту из файла config.php
 */
function sendMailToWinner(Mailer $mailer, array $contactslWinner, string $from, array $completeLot, string $baseUrl)
{
    $email = new Email(); // Объект для подготовки сообщения

    // Подключаем шаблон с текстом письма
    $textEmail = includeTemplate('text_email.php', [
        'completeLot' => $completeLot,
        'contactslWinner' => $contactslWinner,
        'baseUrl' => $baseUrl,
    ]);

    // Отправка сообщения победителю
    $email->to($contactslWinner['userEmail']);
    $email->from($from);
    $email->subject('Ваша ставка победила');
    $email->html($textEmail);
    $mailer->send($email);
}
