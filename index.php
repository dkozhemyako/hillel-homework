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

$tasks = sql_select_tasks($mysqli, $id);

if ($id != null ){

$check_projects = false;
foreach ($projects as $project){
    if ($id === $project['id']){
      $check_projects = true;
    }
}
}

if ($check_projects === false || $id === false){
  header('HTTP/1.0 404 not found');
  exit;
}

if ($id != null){
    $tasks = sql_select_tasks($mysqli, $id);

    $key = 0;
    foreach($projects as $project){
      $projects[$key] = [
        'id' => $project['id'],
        'name' => $project['name'],
        'count' => $project['count'],
        'active' => $id
      ];
    $key++;
    }
} 

$left_sidebar = renderTemplate(
  'left_sidebar.php',
  [
    'name_user_sidebar' => 'Дмитро Кожемяко',
    'projects' => $projects
  ]
);

if ($id != null && $id != false){
  $main = rendertemplate(
    'main.php',
    [ 
      'tasks' => $tasks
    ]
  );
} else if ($id === null){
  $main = '<div class="main-footer">Виберіть або створіть проект</div>';
}

$layout = renderTemplate(
  'layout.php',
  [
    'name_page_title' => 'Завдання та проекти | Дошка', 
    'tasks_content' => $main,
    'main_sidebar' => $left_sidebar
  ]
);

print $layout;




