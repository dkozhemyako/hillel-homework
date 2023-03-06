<?php

session_start();

require_once('functions.php');

$mysqli = my_mysqli_connect();

$input_errors = [];

$myinputs = [
    'login'   => '',
    'password' => '',
];

if (isset($_POST['login_btn'])) {
    $args = array(
        'password'   => FILTER_UNSAFE_RAW,
        'login' => FILTER_VALIDATE_EMAIL,
    );

    $myinputs = filter_input_array(INPUT_POST, $args);

    if ($myinputs['login'] === false) {
        $input_errors['login'] = 'Вкажіть логін';
    }

    if (strlen($myinputs['login']) > 100) {
        $input_errors['login'] = 'Максимум 100 символів';
    }

    if ($myinputs['password'] === '') {
        $input_errors['password'] = 'Вкажіть пароль';
    }

    if (strlen($myinputs['password']) < 8) {
        $input_errors['password'] = 'Мінімум 8 символів';
    }

    $checkLogin = checkLogin($mysqli, $myinputs['login'], $myinputs['password']);

    if ($checkLogin == 0) {
        $input_errors['checkpassword'] = 'Логін та/чи пароль не вірний';
    }

    if (empty($input_errors)) {
        $_SESSION['authorization'] = true;
        $_SESSION['user_id'] = $checkLogin['id'];
        $_SESSION['user_name'] = $checkLogin['name'];
        header("Location: index.php");
    }
}

print renderTemplate(
    'auth.php',
    [
        'myinputs' => $myinputs,
        'input_errors' => $input_errors,

    ],
);
