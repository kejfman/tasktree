<?php

/**
 * Zmiana statusu zadania - ZAKOŃCZONE
 * ©Copyright 2019
 * Karol Osica
 */

require_once '../../entryPoint.php';
require_once '../../class/Task.php';

//zmiana statusu zadania
Task::setDoneStatus($db_connect, $_GET['taskID']);
