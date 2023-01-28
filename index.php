<?php
require_once('functions.php');

$project = renderTemplate ('project.php');
$card = renderTemplate('card.php');

$left_sidebar = renderTemplate(
  'left_sidebar.php',
  [
    'name_project_sidebar' => $project.$project,
    'name_user_sidebar' => 'Кожемяко Дмитро'
  ]
);

$main = rendertemplate(
  'main.php',
  [
    'card_backlog' => $card, 
    'card_to_do' => $card,
    'card_in_progress' => $card, 
    'card_done'  => $card
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