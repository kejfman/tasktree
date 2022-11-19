<?php

/**
 * Zarządzenie słownikami
 * ©Copyright 2019
 * Karol Osica
 * 
 */
require_once '../../entryPoint.php';
require_once '../../class/Dictionary.php';

if (isset($_REQUEST['add'])) { //dodawanie wartości do słownika

    if (!isset($_GET['value']) || $_GET['value'] == '') { //zabezpieczenie przed dodaniem pustej wartości
        $errorMsg = 'Wprowadź wartość!';
        include_once '../../templates/error_tpl.php';
        exit;
    }

    //Dodanie wartości do słownika
    $message = Dictionary::addToDictionary($db_connect, $_GET['dict'], $_GET['value']);
    if (isset($message['nok'])) {
        $errorMsg = '';
        foreach ($message['nok'] as $key => $value) {
            $errorMsg .= $value . '<br />';
        }
        include_once '../../templates/error_tpl.php';
        exit;
    }
} elseif (isset($_REQUEST['dell'])) { //usuwanie wartości ze słownika

    if (!isset($_GET['id']) || $_GET['id'] == '') { //zabezpieczenie w przypadku nie zaznaczenia żadnej z wartości
        $errorMsg = 'Nie wybrano wartości!';
        include_once '../../templates/error_tpl.php';
        exit;
    }

    //Usuwanie wybranych wartości ze słownika
    $message = Dictionary::deleteValueDictionary($db_connect, $_GET['id']);
    if (isset($message['nok'])) {
        $errorMsg = '';
        foreach ($message['nok'] as $key => $value) {
            $errorMsg .= $value . '<br />';
        }
        include_once '../../templates/error_tpl.php';
        exit;
    }
}
