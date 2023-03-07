<?php

session_start();

if (empty($_SESSION['authorization'])) {
    print renderTemplate(
        'guest.php'
    );
    die;
}

require_once('vendor/autoload.php');

$input = json_decode(
    file_get_contents("php://input"),
    true,
);

$mysqli = my_mysqli_connect();

$user_id = $_SESSION['user_id'];

$tasks = sql_select_tasks_user($mysqli, $user_id);

if (!checkTasks($input['id'], $tasks)) {
    die('Нема доступу до завдання');
}

$gump = new GUMP();
$gump->validation_rules(
    [
    'status' => 'contains_list,backlog;to-do;in-progress;done',
    ]
);

$valid_data = $gump->run($input);

if ($input['status'] === 'backlog') {
    $input['status'] = 'back-log';
}

if ($valid_data !== false) {
    $changeStatus = changeStatus(
        $mysqli,
        $input['status'],
        $input['id'],
    );
}
