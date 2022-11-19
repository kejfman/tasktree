<?php
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';

if (isset($_GET['treeID'])) {
    $treeID = explode("^", $_GET['treeID']);
    $treeID = $treeID[0];
    $treeDetails = Tree::getTreeDetails($db_connect, $treeID);
    $taskList = Tree::getTasksList($db_connect, $treeID);
    // var_dump($taskList);

    $taskTable = "";
    $s = 1;
    for ($i = 0; $i < count($taskList); $i++) {
        $taskTable .= "<tr>";
        $taskTable .= "<td>" . $s . ".</td>";
        $taskTable .= "<td>" . $taskList[$i]['TaskNumber'] . "</td>";
        $taskTable .= "<td>" . $taskList[$i]['TaskOwner'] . "</td>";
        $taskTable .= "<td>" . $taskList[$i]['TaskType'] . "</td>";
        $taskTable .= '<td><button id="' . $taskList[$i]['id'] . '" type="button" class="btn btn-sm btn-outline-info btn-task-TASK">Wybierz</button></td>';
        $taskTable .= "</tr>";
        $s++;
    }
}

?>
<div class="shadow card">
    <div class="card-header bg-secondary text-center">
        <font size="5" class="text-light" id="selectedTreeName">Wybrano - <b><?= $treeDetails['TreeName'] ?></b></font>
    </div>
    <div class="card-body" style="height: 280px; overflow-y: scroll;">

        <table class="table table-sm">
            <tbody>
                <?= $taskTable ?>
            </tbody>
        </table>

    </div>
</div>