<?php
require_once '../entryPoint.php';
require_once '../class/Task.php';

if (isset($_GET['treeID'])) {
    // var_dump($_GET['treeID']); 

    $myTasks = Task::getTasksList($db_connect, $_GET['treeID'], 1);
    $otherTasks = Task::getTasksList($db_connect, $_GET['treeID'], 0);



    /**
     * blokowane przez AA001
     */
}
?>
<div class="row justify-content-center">
    <div class="col-sm-7" id="treeContent">
        <div class="shadow card">
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <thead>
                        <tr style="text-align:center;">
                            <th style="border-bottom: solid 2px #17a2b8">Zadania blokujące</th>
                            <th style="border-left: solid 2px #17a2b8; border-right: solid 2px #17a2b8; border-bottom: solid 2px #17a2b8">Moje zadania</th>
                            <th style="border-bottom: solid 2px #17a2b8">Zadania blokowane</th>
                        </tr>
                    </thead>
                    <?php
                    if (isset($myTasks) && is_array($myTasks)) {
                        for ($i = 0; $i < count($myTasks); $i++) {
                            ?>
                            <tr>
                                <td style="text-align:right; width:40%; vertical-align:middle;">
                                    <?php
                                            $tasksBlocked = Task::getBlocksTasks($db_connect, $myTasks[$i]['TaskNumber'], "by");
                                            if (isset($tasksBlocked) && is_array($tasksBlocked)) {
                                                for ($k = 0; $k < count($tasksBlocked); $k++) {
                                                    if ($tasksBlocked[$k]['Done'] == '0') {
                                                        ?>
                                                <button id="<?= $tasksBlocked[$k]['id'] ?>" type="button" class="btn btn-sm btn-outline-dark btn-task" style="margin-top: 5px; width: 45%;"><?= $tasksBlocked[$k]['TaskNumber'] ?></button>
                                            <?php
                                                            } else {
                                                                ?>
                                                <button id="<?= $tasksBlocked[$k]['id'] ?>" type="button" class="btn btn-sm btn-dark btn-task" style="margin-top: 5px; width: 45%;"><?= $tasksBlocked[$k]['TaskNumber'] ?></button>
                                    <?php
                                                    }
                                                }
                                            }
                                            ?>
                                </td>
                                <td style="text-align:center; width:20%; vertical-align:middle;  border-left: solid 2px #17a2b8;  border-right: solid 2px #17a2b8">
                                    <?php
                                            if ($myTasks[$i]['Done'] == '0') {
                                                ?>
                                        <button id="<?= $myTasks[$i]['id'] ?>" type="button" class="btn btn-sm btn-outline-info btn-task" style="margin-top: 5px; width: 100%;"><?= $myTasks[$i]['TaskNumber'] ?></button>
                                    <?php
                                            } else {
                                                ?>
                                        <button id="<?= $myTasks[$i]['id'] ?>" type="button" class="btn btn-sm btn-info btn-task" style="margin-top: 5px; width: 100%;"><?= $myTasks[$i]['TaskNumber'] ?></button>
                                    <?php
                                            } ?>
                                </td>
                                <td style="text-align:left; width:40%; vertical-align:middle;">
                                    <?php
                                            $tasksBlocks = Task::getBlocksTasks($db_connect, $myTasks[$i]['TaskNumber'], "s");
                                            // var_dump($tasksBlocks);
                                            if (isset($tasksBlocks) && is_array($tasksBlocks)) {
                                                for ($l = 0; $l < count($tasksBlocks); $l++) {
                                                    if ($tasksBlocks[$l]['Done'] == '0') {
                                                        ?>
                                                <button id="<?= $tasksBlocks[$l]['id'] ?>" type="button" class="btn btn-sm btn-outline-dark btn-task" style="margin-top: 5px; width: 45%;"><?= $tasksBlocks[$l]['TaskNumber'] ?></button>
                                            <?php
                                                            } else {

                                                                ?>
                                                <button id="<?= $tasksBlocks[$l]['id'] ?>" type="button" class="btn btn-sm btn-dark btn-task" style="margin-top: 5px; width: 45%;"><?= $tasksBlocks[$l]['TaskNumber'] ?></button>
                                    <?php
                                                    }
                                                }
                                            }
                                            ?>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
                        <tr>
                            <td style=" text-align:center;"><i>Brak zadań dla wybranego drzewa!</i></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <?php
                // var_dump($treeDetails);
                ?>
            </div>
        </div>
    </div>

    <div class="col-sm-5" id="taskDet"></div>

</div>
<script>
    $(document).on('click', ".btn-task", function() {
        var taskID = $(this).attr("id");
        $("#taskDet").load("templates/selectedTaskDetails_tpl.php?taskID=" + taskID, function(responseTxt, statusTxt, xhr) {
            if (statusTxt == "error")
                alert("Błąd! Skontaktuj się z administratorem!");
        });
    });
</script>