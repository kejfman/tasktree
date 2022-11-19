<?php

/**
 * Formularz lista drzew
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Task.php';
require_once '../../class/Tree.php';

// Pobieranie pełnej listy drzew
$treesList = Tree::getTreesList($db_connect);
$treesListTable = "";
if ($treesList != null) {
    for ($i = 0; $i < count($treesList); $i++) {
        $treeNameGET = str_replace(" ", "_", $treesList[$i]['TreeName']);
        $treesListTable .= "<tr>";
        $treesListTable .= '<td id="treeName">' . $treesList[$i]['TreeName'] . '</td>';
        $treesListTable .= "<td>" . $treesList[$i]['TreeEnv'] . "</td>";
        $treesListTable .= '<td><button id="' . $treesList[$i]['id'] . '" type="button" class="btn btn-sm btn-outline-info btn-tree-TASK">Wybierz</button></td>';
        $treesListTable .= "</tr>";
    }
}
?>

<!-- CZĘŚĆ GRAFICZNA -->

<div class="shadow-lg card border border-primary">
    <div class="card-header bg-light text-center">
        <font size="5" class="text-dark">Wybierz drzewo</font>
    </div>
    <div class="card-body" style="height: 280px; overflow-y: scroll;">
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td colspan="2" id="treeName">Wszystkie Zadania</td>
                    <td><button id="all" type="button" class="btn btn-sm btn-outline-info btn-tree-TASK">Wybierz</button></td>
                </tr>
                <tr>
                    <td colspan="2" id="treeName">Nieprzypisane Zadania</td>
                    <td><button id="all_free" type="button" class="btn btn-sm btn-outline-info btn-tree-TASK">Wybierz</button></td>
                </tr>
                <?= $treesListTable ?>
            </tbody>
        </table>
    </div>
</div>