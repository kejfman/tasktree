<?php
/**
 * Punkt wejściowy aplikacji TaskTree
 * ©Copyright 2019
 * Karol Osica
 */
//var_dump($_SERVER['SERVER_NAME']);
date_default_timezone_set('Europe/Warsaw');

if (
$_SERVER['SERVER_NAME'] == 'tasktree') {
    define('HOST', '127.0.0.1');
    define('USER', 'task');
    define('PASSWORD', 'alamakota');
    define('DATABASE', 'tasktree');
    define('PORT', 3306);
    define('SOCET', '/tmp/mysql.sock');
} else {
    /*define('HOST', 'sql.rezerwa.nazwa.pl');
    define('USER', 'rezerwa_devel');
    define('PASSWORD', 'deveL#2019');
    define('DATABASE', 'rezerwa_devel');
    define('PORT', 3306);
    define('SOCET', '/var/mysql/mysql.sock'); */
	echo "problem z połączeniem";
}




$db_connect = new mysqli(HOST,USER,PASSWORD,DATABASE,PORT);

if ($db_connect->connect_error) {
    include_once './templates/dbError.template.php';
} else {
   $db_connect->set_charset('utf8');
  //echo "połączono";
}
