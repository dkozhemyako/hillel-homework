<?php
require_once('functions.php');

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT, 
[
  'options'=>
    [
      'min_range'=> 1
    ]
]);

$mysqli = my_mysqli_connect();

$user_id = 1;

$projects = sql_select_projects_count_tasks($mysqli,  $user_id);

if (checkProjects($id, $projects) === false && $id !== null){
  header('HTTP/1.0 404 not found');
  exit;
}

$tasks = sql_select_tasks($mysqli, $id);

$left_sidebar = renderTemplate(
  'left_sidebar.php',
  [
    'name_user_sidebar' => 'Дмитро Кожемяко',
    'projects' => $projects,
    'activProject' => $id
    ]
);

$main = '<div class="main-footer">Виберіть або створіть проект</div>';
if ($id != null && $id != false){
  $main = rendertemplate(
    'main.php',
    [ 
      'tasks' => $tasks
    ]
  );
} 

print renderTemplate(
  'layout.php',
  [
    'name_page_title' => 'Завдання та проекти | Дошка', 
    'tasks_content' => $main,
    'main_sidebar' => $left_sidebar
  ]
);

