<?php

require_once '../entryPoint.php';
require_once '../class/Task.php';
require_once '../class/Tree.php';


// $taskList = Task::getAllTasksList($db_connect);

// var_dump($taskList);

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
<div class="container" style="margin-top: 2%;">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="shadow card text-center bg-primary text-light">
                <h2 style="text-align: center;">Drzewa</h2>
            </div>
            <hr>
        </div>
    </div>
    
        <div class="row justify-content-center">
            <hr>
            <div class="col-sm-6">
                <div class="shadow card">
                    <div class="card-header bg-secondary text-center">
                        <font size="5" class="text-light">Wybierz drzewo</font>
                    </div>
                    <div class="card-body" style="height: 200px; overflow-y: scroll;">
                        <table class="table table-sm">
                            <tbody>
                                <?= $treesListTable ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6" id="treeDetails">
            </div>
        </div>
   
    <hr>
    <div class="row justify-content-center">
        <div class="col-sm-12" id="treeContent">
        </div>
    </div>


</div>
<input id="aaa" type="text" hidden />

<script>
    $(document).ready(function() {
        $(document).on('click', ".btn-tree", function() {
            var treeID = $(this).attr("id");
            $("#treeDetails").load("templates/selectedTreeDetails_tpl.php?treeID=" + treeID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
            $("#treeContent").load("templates/treeContent_tpl.php?treeID=" + treeID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });
    });
</script>