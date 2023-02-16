<?php
require_once('functions.php');

$mysqli = my_mysqli_connect();

$users = sql_select_users($mysqli);
$user_id = $users['0']['id'];

$project_id = $_GET['id'];
$projects = sql_select_projects_count_tasks($mysqli,  $user_id);


$tasks = sql_select_tasks($mysqli, $project_id);


$left_sidebar = renderTemplate(
  'left_sidebar.php',
  [
    'name_user_sidebar' => $users['0']['name'],
    'projects' => $projects
  ]
);

$main = rendertemplate(
  'main.php',
  [ 
    'tasks' => $tasks
  ]
);

$layout = renderTemplate(
  'layout.php',
  [
    'name_page_title' => 'Завдання та проекти | Дошка', 
    'tasks_content' => $main,
    'main_sidebar' => $left_sidebar
  ]
);

print $layout;

