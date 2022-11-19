<?php

require_once '../../entryPoint.php';
require_once '../../class/Task.php';
require_once '../../class/Tree.php';

$treesList = Tree::getTreesList($db_connect);
$treesListTable = "";

for ($i = 0; $i < count($treesList); $i++) {
    $treeNameGET = str_replace(" ", "_", $treesList[$i]['TreeName']);

    $treesListTable .= "<tr>";
    $treesListTable .= '<td id="treeName">' . $treesList[$i]['TreeName'] . '</td>';
    $treesListTable .= "<td>" . $treesList[$i]['TreeEnv'] . "</td>";
    $treesListTable .= '<td><button id="' . $treesList[$i]['id'] . '" type="button" class="btn btn-sm btn-outline-info btn-tree">Wybierz</button></td>';
    $treesListTable .= "</tr>";
}

?>
<div class="shadow card">
    <div class="card-header bg-secondary text-center">
        <font size="5" class="text-light">Wybierz drzewo</font>
    </div>
    <div class="card-body" style="height: 280px; overflow-y: scroll;">
        <table class="table table-sm">
            <tbody>
                <?= $treesListTable ?>
            </tbody>
        </table>
    </div>
</div>