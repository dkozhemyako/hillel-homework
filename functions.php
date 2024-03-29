<?php

/**
 * Перевіряє передану дату на відповідність формату 'ГГГГ-ММ-ДД'
 *
 * Приклади використання:
 * isDateValid('2019-01-01'); // true
 * isDateValid('2016-02-29'); // true
 * isDateValid('2019-04-31'); // false
 * isDateValid('10.10.2010'); // false
 * isDateValid('10/10/2010'); // false
 *
 * @param string $date Дата у вигляді рядка
 *
 * @return bool true у разі збігу з форматом 'ГГГГ-ММ-ДД', інакше false
 */
function isDateValid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Створює підготовлений вираз на основі готового SQL запиту і переданих даних
 *
 * @param $link mysqli Ресурс з'єднання
 * @param $sql string SQL запит із плейсхолдерами замість значень
 * @param array $data Дані для вставки на місце плейсхолдерів
 *
 * @return mysqli_stmt Підготовлений вираз
 */
function dbGetPrepareStmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не вдалося ініціалізувати підготовлений вираз: ' . mysqli_error($link);
        throw new ErrorException($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } elseif (is_string($value)) {
                $type = 's';
            } elseif (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не вдалося пов\'язати підготовлений вираз із параметрами: ' . mysqli_error($link);
            throw new ErrorException($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Повертає коректну форму множини
 * Обмеження: тільки для цілих чисел
 *
 * Приклад використання:
 * $remainingMinutes = 5;
 * echo "Я поставив таймер на {$remainingMinutes} " .
 *     getNounPluralForm(
 *         $remainingMinutes,
 *         'хвилина',
 *         'хвилини',
 *         'хвилин'
 *     );
 * Результат: "Я поставив таймер на 5 хвилин"
 *
 * @param int $number Число, за яким обчислюємо форму множини
 * @param string $one Форма однини: яблуко, година, хвилина
 * @param string $two Форма множини для 2, 3, 4: яблука, години, хвилини
 * @param string $many Форма множини для решти чисел
 *
 * @return string Розрахована форма множини
 */
function getNounPluralForm(int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Підключає шаблон, передає туди дані і повертає підсумковий HTML контент
 *
 * @param string $name Шлях до файлу шаблону відносно папки templates
 * @param array $data Асоціативний масив із даними для шаблону
 * @return string Підсумковий HTML
 */
function renderTemplate($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function differenceDateH($date, $add_string = "h", $day = false)
{
    $now = strtotime(date('Y-m-d'));
    if ($day === false) {
        $now = time();
    }
    $userdate = strtotime($date);
    $calc = floor(($userdate - $now) / 3600);

    $calc <= 24 ? $badge = 'danger' : $badge = 'success';
    $calc < 0 ? $calc = 0 : $calc;

    $calc = sprintf('%d %s', $calc, $add_string);
    return $result = ['badge' => $badge, 'calc' => $calc];
}


function my_mysqli_connect()
{
    mysqli_report(MYSQLI_REPORT_ERROR);
    $result = mysqli_connect("localhost", "root", "", "scheduler_db");
    mysqli_set_charset($result, "utf8");

    if ($result === false) {
        die('Can`t connect to database');
    }

    return $result;
}

function sql_select_tasks($mysqli, $project_id, $filter = [])
{
    $request = "select * from tasks where project_id=?";
    $args = [
        'i',
        $project_id,
    ];

    if (!empty($filter) && $filter['dateTo'] !== null && $filter['dateFrom'] !== null) {
        $request .= ' and date_deadline between ? and ?';
        $args[0] .= 'ss';
        $args[] = $filter['dateFrom'];
        $args[] = $filter['dateTo'];
    } elseif (!empty($filter) && $filter['dateTo'] !== null) {
        $request .= ' and date_deadline <= ?';
        $args[0] .= 's';
        $args[] = $filter['dateTo'];
    }

    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
        die('mysqli_prepare is not complited');
    }

    array_unshift($args, $stmt);

    call_user_func_array('mysqli_stmt_bind_param', $args);

    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
        die('mysqli_stmt_execute is not complited');
    }

    $stmt_res = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($stmt_res, MYSQLI_ASSOC);
    return $result;
}

function sql_select_projects_count_tasks($mysqli, $user_id)
{
    $request = "select projects.name, projects.id, count(tasks.id) as count 
    from projects left join tasks 
    on projects.id = tasks.project_id 
    where projects.user_id= ? 
    GROUP BY projects.id";
    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
        die('mysqli_prepare is not complited');
    }
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
        die('mysqli_stmt_execute is not complited');
    }

    $stmt_res = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($stmt_res, MYSQLI_ASSOC);
    return $result;
}

function checkProjects($id, $projects = [])
{
    if ($id !== null && $id !== false) {
        foreach ($projects as $project) {
            if ($id === $project['id']) {
                return true;
            }
        }
    }
        return false;
}

function tasksAdd($mysqli, $created_at, $name, $body, $data_set, $date_deadline, $user_id, $project_id)
{
    $request = "insert into tasks
    (created_at, name, body, data_set, date_deadline, user_id, project_id)
    values (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
        die('mysqli_prepare is not complited');
    }
    mysqli_stmt_bind_param(
        $stmt,
        'sssssii',
        $created_at,
        $name,
        $body,
        $data_set,
        $date_deadline,
        $user_id,
        $project_id
    );
    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
        die('mysqli_stmt_execute is not complited');
    }
    return true;
}

function usersAdd($mysqli, $created_at, $email, $pass, $name)
{
    $request = "insert into users
    (created_at, email, pass, name)
    values (?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
        die('mysqli_prepare is not complited');
    }
    mysqli_stmt_bind_param(
        $stmt,
        'ssss',
        $created_at,
        $email,
        $pass,
        $name,
    );
    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
        die('mysqli_stmt_execute is not complited');
    }
    return true;
}

function checkUsers($mysqli, $email)
{
    $request = "select email from users where email =?";
    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
        die('mysqli_prepare is not complited');
    }
    mysqli_stmt_bind_param(
        $stmt,
        's',
        $email,
    );
    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
        die('mysqli_stmt_execute is not complited');
    }
    $stmt_res = mysqli_stmt_get_result($stmt);
    if ($stmt_res === false) {
        die('mysqli_stmt_get_result is not complited');
    }
    if ($stmt_res->num_rows > 0) {
        return false;
    }
}

function checkLogin($mysqli, $email, $password)
{
    if ($email !== '' && $password !== '') {
        $request = "select pass, id, name from users where email =?";
        $stmt = mysqli_prepare($mysqli, $request);
        if ($stmt === false) {
            die('mysqli_prepare is not complited');
        }
        mysqli_stmt_bind_param(
            $stmt,
            's',
            $email,
        );
        $check_sql = mysqli_stmt_execute($stmt);
        if ($check_sql === false) {
            die('mysqli_stmt_execute is not complited');
        }
        $stmt_res = mysqli_stmt_get_result($stmt);
        if ($stmt_res === false) {
            die('mysqli_stmt_get_result is not complited');
        }
        $result = mysqli_fetch_all($stmt_res, MYSQLI_ASSOC);
        if ($stmt_res->num_rows > 0 && password_verify($password, $result['0']['pass'])) {
            return
            [
                'id' => $result['0']['id'],
                'name' => $result['0']['name'],
            ];
        }
    }
    return 0;
}

function projAdd($mysqli, $inputName, $user_id)
{
    $request = "insert into projects
    (name, user_id)
    values (?, ?)";
    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
        die('mysqli_prepare is not complited');
    }
    mysqli_stmt_bind_param(
        $stmt,
        'si',
        $inputName,
        $user_id,
    );
    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
        die('mysqli_stmt_execute is not complited');
    }
    return true;
}

function sql_select_tasks_user($mysqli, $user_id)
{
    $request = "select * from tasks where user_id= ?";

    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
        die('mysqli_prepare is not complited');
    }

    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
        die('mysqli_stmt_execute is not complited');
    }

    $stmt_res = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($stmt_res, MYSQLI_ASSOC);
    return $result;
}

function checkTasks($id, $tasks = [])
{
    if ($id !== null && $id !== false) {
        foreach ($tasks as $task) {
            if ($id === $task['id']) {
                return true;
            }
        }
    }
        return false;
}

function changeStatus($mysqli, $status, $task_id)
{
    $request = "update tasks set status = ? where id = ?";
    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
        die('mysqli_prepare is not complited');
    }
    mysqli_stmt_bind_param(
        $stmt,
        'si',
        $status,
        $task_id,
    );
    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
        die('mysqli_stmt_execute is not complited');
    }
    return true;
}

/*
function filterTask($tasks, $filter)
{
    $today = [];
    $tomorrow = [];
    $overdue = [];

    if ($filter === 'all') {
        return $tasks;
    }

    foreach ($tasks as $task) {
        if ($task['date_deadline'] !== null) {
            $diff = differenceDateH($task['date_deadline'], '', true)['calc'];
            if ($diff > 0 && $diff <= 24) {
                $today[] = $task;
            }
            if ($diff > 24 && $diff <= 48) {
                $tomorrow[] = $task;
            }
            if ($diff == 0) {
                $overdue[] = $task;
            }
        }
    }

    if ($filter === 'today') {
        return $today;
    }
    if ($filter === 'tomorrow') {
        return $tomorrow;
    }
    if ($filter === 'overdue') {
        return $overdue;
    }
}
*/

function filterTask($filter)
{
    $dateFrom = null;
    $dateTo = null;

    switch ($filter) {
        case 'today':
            $dateFrom = date('Y-m-d') . ' 00:00:00';
            $dateTo = date('Y-m-d') . ' 23:59:59';
            break;
        case 'tomorrow':
            $dateFrom = date('Y-m-d', strtotime('tomorrow')) . ' 00:00:00';
            $dateTo = date('Y-m-d', strtotime('tomorrow')) . ' 23:59:59';
            break;
        case 'overdue':
            $dateTo = date('Y-m-d', strtotime('yesterday')) . ' 23:59:59';
            break;
        default:
            break;
    }

    return
    [
        'dateFrom' => $dateFrom,
        'dateTo' => $dateTo,
    ];
}

function notifyTasks($mysqli, $dateTo, $dateFrom, $statusCut)
{
    $request = "
        select tasks.name as task_name, users.email, users.name as user_name, users.id
        from tasks left join users 
        on tasks.user_id = users.id 
        where tasks.status != ?
        and tasks.date_deadline between ? and ?
        ORDER BY users.email";
    $stmt = mysqli_prepare($mysqli, $request);
    if ($stmt === false) {
            die('mysqli_prepare is not complited');
    }
    mysqli_stmt_bind_param($stmt, 'sss', $statusCut, $dateTo, $dateFrom);
    $check_sql = mysqli_stmt_execute($stmt);
    if ($check_sql === false) {
            die('mysqli_stmt_execute is not complited');
    }
    $stmt_res = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($stmt_res, MYSQLI_ASSOC);
    return $result;
}
