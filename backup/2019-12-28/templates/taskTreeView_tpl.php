<?php

require_once '../../entryPoint.php';
require_once '../../class/Task.php';
require_once '../../class/Tree.php';


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


<script>
    $(document).ready(function() {
        $(document).on('click', ".btn-tree", function() {
            var treeID = $(this).attr("id");
            $("#treeDetails").load("templates/TreeDetails/selectedTreeDetails_tpl.php?treeID=" + treeID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
            $("#treeContent").load("templates/TreeDetails/treeContent_tpl.php?treeID=" + treeID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });
    });
</script>