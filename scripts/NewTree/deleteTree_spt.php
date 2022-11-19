<?php

/**
 * Usuwanie wybranego drzewa
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';

//Przypisanie identyfikatora usuwanego drzewa
$treeDetails['TreeId'] = $_GET['deleteTree'];


if ($treeDetails['TreeId'] == '') { //komunikat w przypadku nie wybranie drzewa
    $errorMsg = 'Nie wybrano drzewa!';
    include_once '../../templates/error_tpl.php';
} else {
    //Usuwanie drzewa
    $message = Tree::deleteTree($db_connect, $treeDetails);
    if (isset($message['nok'])) { //komunikaty o błędach
        $errorMsg = '';
        foreach ($message['nok'] as $key => $value) {
            $errorMsg .= $value . '<br />';
        }
        include_once '../../templates/error_tpl.php';
    }
}
