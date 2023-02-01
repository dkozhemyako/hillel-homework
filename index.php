<?php
require_once('functions.php');


$projects=
[
  'project_1' => 
  [
    [
      'id' => 1,
      'name_project' => 'Проект 1',
      'count_task_in_project' => '9',
      'active' => true
    ]
  ],
  'project_2' => 
  [
    [
      'id' => 2,
      'name_project' => 'Проект 2',
      'count_task_in_project' => '5',
      'active' => false
    ]
  ]
];

$tasks = 
[
  'task_backlog' =>
  [
    [
      'id' => 1,
      'header' => 'Назва задачі 1',
      'body' => 'Опис задачі 1',
      'deadline_date' => '02.02.2023'
    ]
  ],
  'task_to_do' =>
  [
    [
    'id' => 2,
    'header' => 'Назва задачі 2',
    'body' => 'Опис задачі 2',
    'deadline_date' => '02-02-2023'
    ]
  ],
  'task_in_progress' =>
  [
    [
    'id' => 3,
    'header' => 'Назва задачі 3',
    'body' => 'Опис задачі 3',
    'deadline_date' => '04.02.2023'
    ]
  ],
  'task_done' =>
  [
    [
    'id' => 4,
    'header' => 'Назва задачі 4',
    'body' => 'Опис задачі 4',
    'deadline_date' => ''
    ]
  ]
];


$left_sidebar = renderTemplate(
  'left_sidebar.php',
  [
    'name_project_sidebar' => $project.$project,
    'name_user_sidebar' => 'Кожемяко Дмитро',
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

?>