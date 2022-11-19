<?php

/**
 * Tworzenie kopi drzewa zadań
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';
require_once '../../class/Task.php';

//Odczt wartości z formularza
$treeDetails['TreeName'] = $_REQUEST['addTreeName'];
$treeDetails['TreeEnv'] = $_REQUEST['TreeEnv'];
$treeDetails['copyTree'] = $_REQUEST['CloneTree'];

if ($treeDetails['TreeName'] == '') { //zabezpieczenie w przypadku nie podania nazwy drzewa
    $errorMsg = 'Nie podano nazwy drzewa!';
    include_once '../../templates/error_tpl.php';
} else {
    //Tworzenie nowego drzewa
    $message1 = Tree::addNewTree($db_connect, $treeDetails);

    if (!isset($message['nok'])) {
        $message2 = Task::cloneTreeTasks($db_connect, $treeDetails['copyTree'], $treeDetails['TreeName']);
    }

    if (isset($message1['ok'])) {
        foreach ($message1['ok'] as $key => $value) {
            $message['ok'][] =  $value;
        }
    }

    if (isset($message1['nok'])) {
        foreach ($message1['nok'] as $key => $value) {
            $message['nok'][] =  $value;
        }
    }

    if (isset($message2['ok'])) {
        foreach ($message2['ok'] as $key => $value) {
            $message['ok'][] =  $value;
        }
    }

    if (isset($message2['nok'])) {
        foreach ($message2['nok'] as $key => $value) {
            $message['nok'][] =  $value;
        }
    }

    // komunikat o błędach
    if (isset($message['nok'])) {
        $errorMsg = '';
        foreach ($message['nok'] as $key => $value) {
            $errorMsg .= $value . '<br />';
        }
        include_once '../../templates/error_tpl.php';
    } elseif (isset($message['ok'])) {
        $infoMsg  = '';
        foreach ($message['ok'] as $key => $value) {
            $infoMsg  .= $value . '<br />';
        }
        include_once '../../templates/info_tpl.php';
    }
}
