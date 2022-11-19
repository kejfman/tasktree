<?php
require_once '../../entryPoint.php';
require_once '../../class/Task.php';

$selectedTaskTrees = Task::getTasksList($db_connect, $_REQUEST['tree']);



if (is_array($selectedTaskTrees) && !empty($selectedTaskTrees)) {
    $selectedTaskTreesTableBlocks = '';
    for ($i = 0; $i < count($selectedTaskTrees); $i++) {
        $selectedTaskTreesTableBlocks .=  '<tr>';
        $selectedTaskTreesTableBlocks .=  '<td>' . $selectedTaskTrees[$i]['TaskNumber'] . '</td>';
        $selectedTaskTreesTableBlocks .=  '<td><button id="' . $selectedTaskTrees[$i]['id'] . '" class="btn btn-sm btn-outline-info btn-task"> Wybierz </button></td>';
        $selectedTaskTreesTableBlocks .=  '</tr>';
    }
    ?>



    <div class="shadow card">
        <div class="card-body" style="width: 100%; height: 300px; overflow-y: scroll;">

            <table class="table table-sm table-hover" id="selectedTaskTreesTable">
                <tbody>
                    <?= $selectedTaskTreesTableBlocks ?>
                <tbody>
            </table>
        </div>
    </div>





    <script>
        $(document).ready(function() {


            $(document).on('click', ".btn-task", function() {
                var taskID = $(this).attr("id");

                $("#selectedTaskDetails").load("templates/ManageTasks/selectedTaskDetails_tpl.php?taskID=" + taskID, function(responseTxt, statusTxt, xhr) {
                    if (statusTxt == "error")
                        alert("Błąd! Skontaktuj się z administratorem!");
                });

            });





        });
    </script>
<?php
}
?>