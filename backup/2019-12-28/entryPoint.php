<?php

date_default_timezone_set('Europe/Warsaw');

define('HOST', 'sql.rezerwa.nazwa.pl');
define('USER', 'rezerwa_devel');
define('PASSWORD', 'deveL#2019');
define('DATABASE', 'rezerwa_devel');
define('PORT', 3306);
define('SOCET', '/var/mysql/mysql.sock');


@$db_connect = new mysqli(HOST, USER, PASSWORD, DATABASE, PORT);

if ($db_connect->connect_error) {
    include_once './templates/dbError.template.php';
} else {
    $db_connect->set_charset('utf8');
}