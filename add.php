<?php

session_start();

require_once('functions.php');

if (empty($_SESSION['authorization'])) {
    print renderTemplate(
        'guest.php'
    );
    die;
}

$mysqli = my_mysqli_connect();

$user_id = $_SESSION['user_id'];

$projects = sql_select_projects_count_tasks($mysqli, $user_id);

$input_errors = [];
$myinputs = [
    'inputName'   => '',
    'inputDescription' => '',
    'selectProject' => '',
    'inputDate' => '',
];

if (isset($_POST['btn_task_add'])) {
    $args = array(
    'inputName'   => FILTER_UNSAFE_RAW,
    'inputDescription' => FILTER_UNSAFE_RAW,
    'selectProject' => FILTER_VALIDATE_INT,
    'inputDate' => FILTER_UNSAFE_RAW,
    );

    $myinputs = filter_input_array(INPUT_POST, $args);

    if (
        isDateValid($myinputs['inputDate']) === false && $myinputs['inputDate'] !== '' ||
        differenceDateH($myinputs['inputDate'], '')['calc'] == 0 && $myinputs['inputDate'] !== ''
    ) {
        $input_errors['inputDate'] = 'Вкажіть коректну дату';
    }

    if (checkProjects($myinputs['selectProject'], $projects) === false) {
        $input_errors['selectProject'] = 'Вкажіть існуючий проект';
    }

    if ($myinputs['inputName'] === '') {
        $input_errors['inputName'] = 'Вкажіть назву задачі';
    }

    if (strlen($myinputs['inputName']) > 50) {
        $input_errors['inputName'] = 'Назва задачі не повинна бути довше ніж 50 символів';
    }

    if (strlen($myinputs['inputDescription']) > 200) {
        $input_errors['inputDescription'] = 'Опис задачі не повинен бути довше ніж 200 символів';
    }

    if (empty($input_errors)) {
        $uploadfile = '';
        $myinputs['inputDate'] = $myinputs['inputDate'] === '' ? null : $myinputs['inputDate'];
        if (isset($_FILES['inputTaskFile'])) {
            move_uploaded_file($_FILES['inputTaskFile']['tmp_name'], $_FILES['inputTaskFile']['name']);
            $uploadfile = $_FILES['inputTaskFile']['name'];
        }
        $taskAdd = tasksAdd(
            $mysqli,
            date('Y-m-d H:i:s'),
            $myinputs['inputName'],
            $myinputs['inputDescription'],
            $uploadfile,
            $myinputs['inputDate'],
            $user_id,
            $myinputs['selectProject'],
        );
        if ($taskAdd === true) {
            header("Location: index.php");
        }
    }
}

$left_sidebar = renderTemplate(
    'left_sidebar.php',
    [
    'name_user_sidebar' => $_SESSION['user_name'],
    'projects' => $projects,
    'activProject' => '',
    ]
);

$task_add = renderTemplate(
    'task-add.php',
    [
    'drop_projects' => $projects,
    'input_errors' => $input_errors,
    'myinputs' => $myinputs,
    ]
);

print renderTemplate(
    'layout.php',
    [
    'name_page_title' => 'Завдання та проекти | Дошка',
    'tasks_content' => $task_add,
    'main_sidebar' => $left_sidebar,
    ]
);
