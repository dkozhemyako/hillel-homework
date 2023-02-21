<?php
require_once('functions.php');

$mysqli = my_mysqli_connect();

$user_id = 1;

$task_drop_projects = sql_select_projects_count_tasks($mysqli, $user_id);

if (isset($_POST['btn_task_add']))
{
  $args = array(
    'inputName'   => FILTER_SANITIZE_STRING,
    'inputDescription' => FILTER_SANITIZE_STRING,
    'selectProject' => FILTER_VALIDATE_INT,
    'inputDate' => FILTER_SANITIZE_STRING,
  );

  $myinputs = filter_input_array(INPUT_POST, $args);

  $projects = sql_select_projects_count_tasks($mysqli,  $user_id);

  $input_errors = [];

  if (isDateValid($myinputs['inputDate']) === false || differenceDateH($myinputs['inputDate'], '')['calc'] == 0)
  {
    $input_errors += ['inputDate' => 'Вкажіть коректну дату'];
  }

  if (checkProjects($myinputs['selectProject'], $projects) === false)
  {
    $input_errors += ['selectProject' => 'Вкажіть існуючий проект'];
  }

  if ($myinputs['inputName'] === '')
  {
    $input_errors += ['inputName' => 'Вкажіть назву задачі'];
  }


  if (empty($input_errors))
  {
    $uploadfile = ''; 
    if (isset($_FILES['inputTaskFile']))
    {
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
      $myinputs['selectProject']);
  
    if ($taskAdd === true)
      {
        header("Location: http://localhost/hillel-homework/index.php");
      }
  }
}

print renderTemplate(
  'task-add.php',
  [
      'drop_projects' => $task_drop_projects,
      'input_errors' => $input_errors,
  ]
);

