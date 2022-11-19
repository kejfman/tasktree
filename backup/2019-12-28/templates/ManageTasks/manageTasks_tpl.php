<?php
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';
require_once '../../class/Dictionary.php';
// TaskTreeList

$treeList = Tree::getTreesList($db_connect);

$TaskTreeList = '';

if (!empty($treeList)) {
    for ($i = 0; $i < count($treeList); $i++) {
        $TaskTreeList .= '<option value="' . $treeList[$i]['id'] . '">' . $treeList[$i]['TreeName'] . '</option>';
    }
}


?>
<div class="container" style="margin-top: 2%;">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="shadow card text-center bg-primary text-light">
                <h2 style="text-align: center;">Zarządzanie zadaniami</h2>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="shadow card">
                <div class="card-header bg-secondary text-center">
                    <font size="5" class="text-light">Wybierz drzewo</font>
                </div>
                <div class="card-body">
                    <div class="form-row" style="font-size: 14px;">
                        <div class="form-group col-md-12">
                            <select id="TaskTree" name="TaskTree" class="form-control form-control-sm">
                                <option value=""> -- wybierz drzewo --</option>
                                <?= $TaskTreeList ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="selectedTaskDetails" class="col-sm-6">
        </div>
    </div>

    <div class="row">
        <div id="selectedTreeTasks" class="col-sm-6" style="margin-top: 10px;">
        </div>

    </div>



</div>

<script>
    $(document).ready(function() {

        $('#TaskTree').change(function() {
            $("#selectedTreeTasks").load("templates/ManageTasks/selectedTreeTasks_tpl.php?tree=" + $(this).val(), function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        })
    });
</script>