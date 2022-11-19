<?php

/**
 * Tworzenie nowego drzewa zadań
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';

//Odczt wartości z formularza
$treeDetails['TreeName'] = $_REQUEST['addTreeName'];
$treeDetails['TreeEnv'] = $_REQUEST['TreeEnv'];

if ($treeDetails['TreeName'] == '') { //zabezpieczenie w przypadku nie podania nazwy drzewa
    $errorMsg = 'Nie podano nazwy drzewa!';
    include_once '../../templates/error_tpl.php';
} else {
    //Tworzenie nowego drzewa
    $message = Tree::addNewTree($db_connect, $treeDetails);
    //komunikat o błędach
    if (isset($message['nok'])) {
        $errorMsg = '';
        foreach ($message['nok'] as $key => $value) {
            $errorMsg .= $value . '<br />';
        }
        include_once '../../templates/error_tpl.php';
    }
}
