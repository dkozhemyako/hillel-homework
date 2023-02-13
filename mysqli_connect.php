<?php 
mysqli_report(MYSQLI_REPORT_ERROR);
$mysqli = mysqli_connect("localhost", "root", "", "scheduler_db");
mysqli_set_charset($mysqli, "utf8");

if ($mysqli === false) {
    die('Can`t connect to database');
}


