<?php

/**
 * Formularz kopiowania drzewa
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';
require_once '../../class/Dictionary.php';


// pobieranie danych wybranego drzewa:

$treeDetails = Tree::getTreeDetails($db_connect, $_REQUEST['tree']);


// var_dump($treeDetails);


// 003.TreeEnvDict
$TreeEnvDictionary = Dictionary::getSelectedDictionaryValues($db_connect, "A003");

$TreeEnvDict = '';

if (!empty($TreeEnvDictionary)) {

    $TreeEnvDict .= '<option>' . $treeDetails['TreeEnv'] . '</option>';
    for ($i = 0; $i < count($TreeEnvDictionary); $i++) {
        if ($TreeEnvDictionary[$i]['value'] == $treeDetails['TreeEnv']) {
            continue;
        } else {
            $TreeEnvDict .= '<option>' . $TreeEnvDictionary[$i]['value'] . '</option>';
        }
    }
}




?>





    <div class="row">
        <div class="col">
            <input type="text" class="form-control form-control-sm" id="addTreeName" name="addTreeName" value="<?= $treeDetails['TreeName'] ?>_copy" placeholder="Wprowadź nazwę kopi drzewa">
        </div>
        <div class="col">
            <select id="TreeEnv" name="TreeEnv" class="form-control form-control-sm">
                <?= $TreeEnvDict ?>
            </select>
        </div>
    </div>

    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <button id="copy_save" type="submit" class="btn btn-sm btn-secondary" style="width: 100%;">Utwórz kopię</button>
        </div>
    </div>



<!-- scripts\NewTree\copyTree_spt.php -->



