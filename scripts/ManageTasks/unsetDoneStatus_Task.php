<?php

/**
 * Zmiana statusu zadania - OTWARTE
 * ©Copyright 2019
 * Karol Osica
 */

require_once '../../entryPoint.php';
require_once '../../class/Task.php';

//zmiana statusu zadania
Task::unsetDoneStatus($db_connect, $_GET['taskID']);
