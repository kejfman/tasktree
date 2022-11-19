<?php
require_once '../entryPoint.php';
require_once '../class/Tree.php';

if (isset($_GET['treeID'])) {
    $treeID = explode("^", $_GET['treeID']);
    $_GET['treeID'] = $treeID[0];
    $treeDetails = Tree::getTreeDetails($db_connect, $_GET['treeID']);
}

?>
<div class="shadow card">
    <div class="card-header bg-secondary text-center">
        <font size="5" class="text-light" id="selectedTreeName"><?= $treeDetails['TreeName'] ?></font>
    </div>
    <div class="card-body" style="height: 200px;">
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td>Środowisko</td>
                    <td><?= $treeDetails['TreeEnv'] ?></td>
                </tr>
                <tr>
                    <td>Data utworzenia</td>
                    <td><?= $treeDetails['CreateDateTime'] ?></td>
                </tr>
                <tr>
                    <td>Data zamknięcia</td>
                    <td><?= $treeDetails['DoneDateTime'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>