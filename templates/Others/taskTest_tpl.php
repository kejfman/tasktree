<?php

require_once '../entryPoint.php';
require_once '../class/Task.php';

$taskList = Task::getAllTasksList($db_connect);

var_dump($taskList);
