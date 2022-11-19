<?php

/**
 * Usuwanie zadania 
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Task.php';

$taskID = $_GET['taskID']; // przypisanie identyfikatora zadania

if ($taskID == '') { //zabezpieczenie w przypadku nie podania id zadania
    $errorMsg = 'Nie wybrano zadania!';
    include_once '../../templates/error_tpl.php';
} else {
    //Usunięcie zadania
    $message = Task::deleteTask($db_connect, $taskID);

    if ($message) { //informacja w przypadku powodzenia
        $infoMsg = 'Zadanie zostało usunięte!';
        include_once '../../templates/info_tpl.php';
    } elseif (!$message) { //informacja w przypadku braku powodzenia
        $errorMsg = 'Błąd podczas usuwania zadania!';
        include_once '../../templates/error_tpl.php';
    }
}
