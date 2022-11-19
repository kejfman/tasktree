<?php

require_once '../entryPoint.php';
require_once '../class/Task.php';

Task::unsetDoneStatus($db_connect, $_GET['taskID']);
