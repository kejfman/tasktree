<?php

require_once '../entryPoint.php';
require_once '../class/Task.php';

Task::setDoneStatus($db_connect, $_GET['taskID']);
