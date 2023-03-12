<?php

require_once('vendor/autoload.php');

$mysqli = my_mysqli_connect();

$dateTo =  date('Y-m-d') . ' 00:00:00';
$dateFrom = date('Y-m-d') . ' 23:59:59';
$notify = notifyTasks($mysqli, $dateTo, $dateFrom, 'done');

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

if (is_array($notify)) {
    $transport = Transport::fromDsn(
        'smtp://79d7c3aeb4ccf4:74d41adc5a3765@sandbox.smtp.mailtrap.io:2525?encryption=tls&auth_mode=login'
    );

    $userId = 0;
    $new = [];
    foreach ($notify as $not) {
        if ($userId !== $not['id']) {
            $new[$not['id']] = $not;
            $userId = $not['id'];
        } else {
            $new[$not['id']]['task_name'] .= ' і ' . $not['task_name'];
        }
    }

    foreach ($new as $not) {
        $mailer = new Mailer($transport);
        $email = (new Email())
        ->from('php@ithillel.ua')
        ->to($not['email'])
        ->subject('Повідомлення від сервісу "Завдання та проекти"')
        ->text('Шановний ' . $not['user_name'] . '. ' . 'У вас заплановано завдання ' .
        $not['task_name'] . ' на ' . date('Y-m-d'));
        $mailer->send($email);
    }
}
