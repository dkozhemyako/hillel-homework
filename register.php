<?php

require_once('functions.php');

$mysqli = my_mysqli_connect();

$input_errors = [];

$myinputs = [
    'reg_name'   => '',
    'reg_email' => '',
    'reg_password' => '',
    'reg_password_check' => '',
    'reeg_agreTerms' => '',
];

if (isset($_POST['reg_btn'])) {
    $args = array(
        'reg_name'   => FILTER_UNSAFE_RAW,
        'reg_email' => FILTER_VALIDATE_EMAIL,
        'reg_password' => FILTER_UNSAFE_RAW,
        'reg_password_check' => FILTER_UNSAFE_RAW,
        'reg_agreTerms' => FILTER_UNSAFE_RAW,
    );

    $myinputs = filter_input_array(INPUT_POST, $args);

    if ($myinputs['reg_name'] === '') {
        $input_errors['reg_name'] = 'Вкажіть ім' . "'" . 'я';
    }

    if (strlen($myinputs['reg_name']) > 30) {
        $input_errors['reg_name'] = 'Максимум 30 символів';
    }

    if ($myinputs['reg_email'] === false) {
        $input_errors['reg_email'] = 'Вкажіть email в форматі example@domain';
    }

    if (strlen($myinputs['reg_email']) > 100) {
        $input_errors['reg_email'] = 'Максимум 100 символів';
    }

    if (checkUsers($mysqli, $myinputs['reg_email']) === false) {
        $input_errors['reg_email'] = 'Такий користувач вже зареєстрований';
    }

    if ($myinputs['reg_password'] === '') {
        $input_errors['reg_password'] = 'Вкажіть пароль';
    }

    if ($myinputs['reg_password_check'] === '') {
        $input_errors['reg_password_check'] = 'Повторіть пароль';
    }

    if ($myinputs['reg_password'] !== $myinputs['reg_password_check']) {
        $input_errors['reg_password_check'] = 'Паролі не співпадають, повторіть спробу';
    }

    if (strlen($myinputs['reg_password']) < 8 || strlen($myinputs['reg_password_check']) < 8) {
        $input_errors['reg_password'] = 'Мінімум 8 символів';
    }

    if ($myinputs['reg_agreTerms'] !== 'agree') {
        $input_errors['reg_agreTerms'] = 'Погодьтесь з ';
    }

    if (!empty($input_errors)) {
        $input_errors['error'] = 'Будь ласка, виправте помилки у формі';
    }

    if (empty($input_errors)) {
        $myinputs['reg_password'] = password_hash($myinputs['reg_password'], PASSWORD_DEFAULT);
        $userAdd = usersAdd(
            $mysqli,
            date('Y-m-d H:i:s'),
            $myinputs['reg_email'],
            $myinputs['reg_password'],
            $myinputs['reg_name'],
        );

        if ($userAdd === true) {
            header("Location: index.php");
        }
    }
}

print renderTemplate(
    'reg.php',
    [
    'input_errors' => $input_errors,
    'myinputs' => $myinputs,
    ]
);
