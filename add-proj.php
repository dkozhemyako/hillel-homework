<?php

session_start();

require_once('vendor/autoload.php');

if (empty($_SESSION['authorization'])) {
    print renderTemplate(
        'guest.php'
    );
    die;
}

$mysqli = my_mysqli_connect();

$user_id = $_SESSION['user_id'];

$projects = sql_select_projects_count_tasks($mysqli, $user_id);

$projectsName = '';
foreach ($projects as $project) {
    $projectsName = $project['name'] . ';' . $projectsName;
}

$valid_data = [
    'inputName' => '',
];

$myinputs = [
    'inputName' => '',
];

$gump = new GUMP();

if (isset($_POST['btn_project_add'])) {
    $myinputs = [
        'inputName' => $_POST['inputName'],
    ];
    $gump->validation_rules(
        [
        'inputName' => 'required|max_len,20|min_len,2|doesnt_contain_list,' . $projectsName,
        ]
    );

    $gump->set_fields_error_messages([
        'inputName' =>
        [
            'required' => 'Вкажіть назву проекту',
            'max_len' => 'Назва проекту не може бути довше 20 символів',
            'min_len' => 'Назва проекту не може бути коротше 2 символів',
            'doesnt_contain_list' => 'Проект з такою назвою вже існує',
        ],
    ]);

    $gump->filter_rules([
        'inputName' => 'trim|sanitize_string',
    ]);

    $valid_data = $gump->run($_POST);

    if ($valid_data !== false) {
        $projAdd = projAdd(
            $mysqli,
            $valid_data['inputName'],
            $user_id,
        );
        if ($projAdd === true) {
            header("Location: index.php");
        }
    }
}

$left_sidebar = renderTemplate(
    'left_sidebar.php',
    [
    'name_user_sidebar' => $_SESSION['user_name'],
    'activProject' => '',
    'projects' => $projects,
    ]
);

$proj_add = renderTemplate(
    'project-add.php',
    [
    'input_errors' => $gump->get_errors_array(),
    'myinputs' => $myinputs,
    ]
);

print renderTemplate(
    'layout.php',
    [
    'name_page_title' => 'Завдання та проекти | Дошка',
    'tasks_content' => $proj_add,
    'main_sidebar' => $left_sidebar,
    ]
);
