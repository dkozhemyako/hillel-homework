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

function differenceDateH($date, $add_string = "h")
{
    $now = time();
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


function sql_select_tasks($mysqli, $project_id)
{
    $request = "select * from tasks where project_id= ?";

    $stmt = mysqli_prepare($mysqli, $request);
    mysqli_stmt_bind_param($stmt, 'i', $project_id);
    $check_sql = mysqli_stmt_execute($stmt);

    if ($check_sql === false) {
        die('SQL request is not complited');
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
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    $check_sql = mysqli_stmt_execute($stmt);

    if ($check_sql === false) {
        die('SQL request is not complited');
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

    if ($check_sql === true) {
        return true;
    }
    return false;
}
