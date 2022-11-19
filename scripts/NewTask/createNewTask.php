<?php

/**
 * Tworzenie nowego zadania
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Task.php';

//Tworzenie tablicy z danymi niezbędnymi do interpretacji zatwierdzonego formularza
if (isset($_REQUEST['TaskTree']) && $_REQUEST['TaskTree'] != '') {
    $errorMsg = '';
    $infoMsg = '';

    if (isset($_REQUEST['MyTask']) && $_REQUEST['MyTask'] == 'on') {
        $_REQUEST['MyTask'] = 1;
    } else {
        $_REQUEST['MyTask'] = 0;
    }

    $taskDetails = [
        'TaskTree' => $_REQUEST['TaskTree'],
        'TaskNumber' => $_REQUEST['TaskNumber'],
        'TaskOwner' => $_REQUEST['TaskOwner'],
        'TaskType' => $_REQUEST['TaskType'],
        'MyTask' => $_REQUEST['MyTask']
    ];

    if (isset($_POST['TaskNumberBlocks']) && $_POST['TaskNumberBlocks'] != null) {
        for ($i = 0; $i < count($_POST['TaskNumberBlocks']); $i++) {
            if ($_POST['TaskTree'] != '' && $_POST['TaskNumberBlocks'][$i] != '') {
                $taskDetails['TaskBlocks'][$i]['TaskTree'] = $_POST['TaskTree'];
                $taskDetails['TaskBlocks'][$i]['TaskNumber'] = $_POST['TaskNumberBlocks'][$i];
            }
        }
    }



    if (isset($_POST['TaskOwnerBlocks']) && $_POST['TaskOwnerBlocks'] != null) {
        for ($i = 0; $i < count($_POST['TaskOwnerBlocks']); $i++) {
            if ($_POST['TaskOwnerBlocks'][$i] != '') {
                $taskDetails['TaskBlocks'][$i]['TaskOwner'] = $_POST['TaskOwnerBlocks'][$i];
            }
        }
    }

    if (isset($_POST['TaskTypeBlocks']) && $_POST['TaskTypeBlocks'] != null) {
        for ($i = 0; $i < count($_POST['TaskTypeBlocks']); $i++) {
            if ($_POST['TaskTypeBlocks'][$i] != '') {
                $taskDetails['TaskBlocks'][$i]['TaskType'] = $_POST['TaskTypeBlocks'][$i];
            }
        }
    }

    if (isset($_POST['TaskNumberBlocked']) && $_POST['TaskNumberBlocked'] != null) {
        for ($i = 0; $i < count($_POST['TaskNumberBlocked']); $i++) {
            if ($_POST['TaskTree'] != '' && $_POST['TaskNumberBlocked'][$i] != '') {
                $taskDetails['TaskBlockedBy'][$i]['TaskTree'] = $_POST['TaskTree'];
                $taskDetails['TaskBlockedBy'][$i]['TaskNumber'] = $_POST['TaskNumberBlocked'][$i];
            }
        }
    }

    if (isset($_POST['TaskOwnerBlocked']) && $_POST['TaskOwnerBlocked'] != null) {
        for ($i = 0; $i < count($_POST['TaskOwnerBlocked']); $i++) {
            if ($_POST['TaskOwnerBlocked'][$i] != '') {
                $taskDetails['TaskBlockedBy'][$i]['TaskOwner'] = $_POST['TaskOwnerBlocked'][$i];
            }
        }
    }

    if (isset($_POST['TaskTypeBlocked']) && $_POST['TaskTypeBlocked'] != null) {
        for ($i = 0; $i < count($_POST['TaskTypeBlocked']); $i++) {
            if ($_POST['TaskTypeBlocked'][$i] != '') {
                $taskDetails['TaskBlockedBy'][$i]['TaskType'] = $_POST['TaskTypeBlocked'][$i];
            }
        }
    }



    if (isset($_POST['selectedBlocksTasks']) && $_POST['selectedBlocksTasks'] != '') {
        $selectedBlocksTasks = explode(",", $_POST['selectedBlocksTasks']);
        for ($i = 0; $i < count($selectedBlocksTasks); $i++) {
            $taskName = Task::getTaskNumberById($db_connect, $selectedBlocksTasks[$i]);
            if (isset($taskName['nok'])) {
                foreach ($taskName['nok'] as $key => $value) {
                    $errorMsg .= $value . '<br />';
                }
            }

            $selectedBlocksTasksLog = Task::setRelation($db_connect, $taskName, $taskDetails['TaskNumber']);
            if (isset($selectedBlocksTasksLog['nok'])) {
                foreach ($selectedBlocksTasksLog['nok'] as $key => $value) {
                    $errorMsg .= $value . '<br />';
                }
            }
        }
    }


    if (isset($_POST['selectedBlockedTasks']) && $_POST['selectedBlockedTasks'] != '') {
        $selectedBlockedTasks = explode(",", $_POST['selectedBlockedTasks']);
        for ($i = 0; $i < count($selectedBlockedTasks); $i++) {
            $taskName = Task::getTaskNumberById($db_connect, $selectedBlockedTasks[$i]);
            if (isset($taskName['nok'])) {
                foreach ($taskName['nok'] as $key => $value) {
                    $errorMsg .= $value . '<br />';
                }
            }

            $selectedBlockedTasksLog = Task::setRelation($db_connect, $taskDetails['TaskNumber'], $taskName);

            if (isset($selectedBlockedTasksLog['nok'])) {
                foreach ($selectedBlockedTasksLog['nok'] as $key => $value) {
                    $errorMsg .= $value . '<br />';
                }
            }
            if (isset($selectedBlockedTasksLog['ok'])) {
                foreach ($selectedBlockedTasksLog['ok'] as $key => $value) {
                    $infoMsg .= $value . '<br />';
                }
            }
        }
    }

    //Dodawanie nowego zadania
    $newTaskLog = Task::addNewTask($db_connect, $taskDetails);

    // KOMUNIKATY O BŁĘDACH:    
    if (isset($newTaskLog['nok'])) {
        foreach ($newTaskLog['nok'] as $key => $value) {
            $errorMsg .= $value . '<br />';
        }
    }
    if (isset($newTaskLog['ok'])) {
        echo '<p hidden>success</p>';
        foreach ($newTaskLog['ok'] as $key => $value) {
            $infoMsg .= $value . '<br />';
        }
    }

    //wyświetlanie komunikatu
    if (isset($errorMsg) && $errorMsg != '') {
        include_once '../../templates/error_tpl.php';
    }

    if (isset($infoMsg) && $infoMsg != '') {
        include_once '../../templates/info_tpl.php';
    }
} else {
    //komunikat w przypadku nie wybrania drzewa zadań
    $errorMsg = 'Nie wybrano Drzewa!';
    include_once '../../templates/error_tpl.php';
}
