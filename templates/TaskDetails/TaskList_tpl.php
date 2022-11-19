<?php

/**
 * Formularz - lista zadań
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';

// Zadania przypisane go wybranego drzewa
if (isset($_GET['treeID'])) {
    $treeID = explode("^", $_GET['treeID']);
    $treeID = $treeID[0];
    if ($treeID == 'all') {
        $taskList = Tree::getTasksList($db_connect, $treeID);
        $treeDetails['TreeName'] = 'Wszystkie Zadania';
    } elseif ($treeID == 'all_free') {
        $taskList = Tree::getTasksList($db_connect, $treeID);
        $treeDetails['TreeName'] = 'Nieprzypisane Zadania';
    } else {
        $treeDetails = Tree::getTreeDetails($db_connect, $treeID);
        $taskList = Tree::getTasksList($db_connect, $treeID);
    }
    $taskTable = "";
    $s = 1;
    if ($taskList != null) {
        for ($i = 0; $i < count($taskList); $i++) {
            $taskTable .= '<tr id="tr_' . $taskList[$i]['id'] . '">';
            $taskTable .= "<td>" . $s . ".</td>";
            $taskTable .= "<td>" . $taskList[$i]['TaskNumber'] . "</td>";
            $taskTable .= "<td>" . $taskList[$i]['TaskOwner'] . "</td>";
            $taskTable .= "<td>" . $taskList[$i]['TaskType'] . "</td>";
            $taskTable .= '<td><button id="btn_' . $taskList[$i]['id'] . '" type="button" class="btn btn-sm btn-outline-info btn-task-TASK">Wybierz</button></td>';
            $taskTable .= "</tr>";
            $s++;
        }
    }
}
?>

<!-- CZĘŚĆ GRAFICZNA -->

<div class="shadow-lg card border border-primary">
    <div class="card-header bg-light text-center">
        <font size="5" class="text-dark" id="selectedTreeName">Wybrano - <b><?= $treeDetails['TreeName'] ?></b></font>
    </div>
    <div class="card-body" style="height: 280px; overflow-y: scroll;">
        <table class="table table-sm">
            <tbody>
                <?= $taskTable ?>
            </tbody>
        </table>
    </div>
</div>