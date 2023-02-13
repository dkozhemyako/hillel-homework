<?php
require_once('functions.php');

$users = mysqli_assoc(
  $request = "select * from users"
);

$projects = mysqli_assoc(
  $request = "select * from projects where user_id=" . $users['0']['id']
);
  
$tasks = mysqli_assoc(
  $request = "select * from tasks where project_id=" . $_GET['id']
);

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

