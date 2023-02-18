<?php
require_once('functions.php');

$mysqli = my_mysqli_connect();

$user_id = 1;

$task_drop_projects = sql_select_projects_count_tasks($mysqli, $user_id);

if(isset($_POST['btn_task_add'])){



   

/*

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT, 
[
  'options'=>
    [
      'min_range'=> 1
    ]
]);


inputName ('')
inputDescription ('')
selectProject 
inputDate ('')
inputTaskFile ?
*/



}



print renderTemplate(
    'task-add.php',
    [
        'drop_projects' => $task_drop_projects
    ]

);

