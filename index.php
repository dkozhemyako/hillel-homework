<?php

session_start();

require_once('functions.php');

if (empty($_SESSION['authorization'])) {
    print renderTemplate(
        'guest.php'
    );
    die;
}

$id = filter_input(
    INPUT_GET,
    "id",
    FILTER_VALIDATE_INT,
    [
     'options' =>
     [
      'min_range' => 1
     ],
    ],
);

$mysqli = my_mysqli_connect();

$user_id = $_SESSION['user_id'];

$projects = sql_select_projects_count_tasks(
    $mysqli,
    $user_id,
);

if (checkProjects($id, $projects) === false && $id !== null) {
    header('HTTP/1.0 404 not found');
    exit;
}

$filter = filterTask($_GET['filter']);
$tasks = sql_select_tasks(
    $mysqli,
    $id,
    $filter,
);
$active_filter = $_GET['filter'];



$left_sidebar = renderTemplate(
    'left_sidebar.php',
    [
    'name_user_sidebar' => $_SESSION['user_name'],
    'projects' => $projects,
    'activProject' => $id,
    ]
);

$main = '<div class="main-footer">Виберіть чи створіть проект</div>';

if ($id != null && $id != false) {
    $main = rendertemplate(
        'main.php',
        [
        'tasks' => $tasks,
        'id' => $id,
        'active_filter' => $active_filter,
        ],
    );
}

print renderTemplate(
    'layout.php',
    [
    'name_page_title' => 'Завдання та проекти | Дошка',
    'tasks_content' => $main,
    'main_sidebar' => $left_sidebar,
    ]
);
