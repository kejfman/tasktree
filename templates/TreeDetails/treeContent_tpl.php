<?php

/**
 * Formularz - Główny - Zawartość wybranego drzewa
 */
require_once '../../entryPoint.php';
require_once '../../class/Task.php';
require_once '../../class/Tree.php';

// Pobieranie listy własnych zadań oraz reszty
if (isset($_GET['treeID'])) {
    $myTasks = Tree::getTasksList($db_connect, $_GET['treeID'], 1);
    $otherTasks = Tree::getTasksList($db_connect, $_GET['treeID'], 0);
}
?>

<!-- CZĘŚĆ GRAFICZNA -->

<div class="shadow-lg card border border-primary">
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
                        <td style="text-align:right; width:40%; vertical-align:middle; border-bottom: solid 2px #17a2b8">
                            <?php
                            $tasksBlocked = Task::getBlocksTasks($db_connect, $myTasks[$i]['TaskNumber'], "by", $_GET['treeID']);
                            if (isset($tasksBlocked) && is_array($tasksBlocked)) {
                                for ($k = 0; $k < count($tasksBlocked); $k++) {
                                    if ($tasksBlocked[$k]['Done'] == '0') {
                            ?>
                                        <button id="<?= $tasksBlocked[$k]['id'] ?>" name="<?= $tasksBlocked[$k]['id'] ?>" type="button" class="btn btn-sm btn-outline-danger btn-task <?= $tasksBlocked[$k]['id'] ?>" style="margin-top: 5px; width: 45%;"><?= $tasksBlocked[$k]['TaskNumber'] ?></button>
                                    <?php
                                    } else {
                                    ?>
                                        <button id="<?= $tasksBlocked[$k]['id'] ?>" name="<?= $tasksBlocked[$k]['id'] ?>" type="button" class="btn btn-sm btn-danger btn-task <?= $tasksBlocked[$k]['id'] ?>" style="margin-top: 5px; width: 45%;"><?= $tasksBlocked[$k]['TaskNumber'] ?></button>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align:center; width:20%; vertical-align:middle;  border-left: solid 2px #17a2b8;  border-right: solid 2px #17a2b8; border-bottom: solid 2px #17a2b8">
                            <?php
                            if ($myTasks[$i]['Done'] == '0') {
                            ?>
                                <button id="<?= $myTasks[$i]['id'] ?>" name="<?= $myTasks[$i]['id'] ?>" type="button" class="btn btn-sm btn-outline-info btn-task <?= $myTasks[$i]['id'] ?>" style="margin-top: 5px; width: 100%;"><?= $myTasks[$i]['TaskNumber'] ?></button>
                            <?php
                            } else {
                            ?>
                                <button id="<?= $myTasks[$i]['id'] ?>" name="<?= $myTasks[$i]['id'] ?>" type="button" class="btn btn-sm btn-info btn-task <?= $myTasks[$i]['id'] ?>" style="margin-top: 5px; width: 100%;"><?= $myTasks[$i]['TaskNumber'] ?></button>
                            <?php
                            } ?>
                        </td>
                        <td style="text-align:left; width:40%; vertical-align:middle; border-bottom: solid 2px #17a2b8">
                            <?php
                            $tasksBlocks = Task::getBlocksTasks($db_connect, $myTasks[$i]['TaskNumber'], "s", $_GET['treeID']);
                            if (isset($tasksBlocks) && is_array($tasksBlocks)) {
                                for ($l = 0; $l < count($tasksBlocks); $l++) {
                                    if ($tasksBlocks[$l]['Done'] == '0') {
                            ?>
                                        <button id="<?= $tasksBlocks[$l]['id'] ?>" name="<?= $tasksBlocks[$l]['id'] ?>" type="button" class="btn btn-sm btn-outline-dark btn-task <?= $tasksBlocks[$l]['id'] ?>" style="margin-top: 5px; width: 45%;"><?= $tasksBlocks[$l]['TaskNumber'] ?></button>
                                    <?php
                                    } else {
                                    ?>
                                        <button id="<?= $tasksBlocks[$l]['id'] ?>" name="<?= $tasksBlocks[$l]['id'] ?>" type="button" class="btn btn-sm btn-dark btn-task <?= $tasksBlocks[$l]['id'] ?>" style="margin-top: 5px; width: 45%;"><?= $tasksBlocks[$l]['TaskNumber'] ?></button>
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
                    <td colspan="3" style=" text-align:center;"><br />
                        <font color="red"><i>Brak zadań przypisanych do Ciebie!</i></font>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>

<!-- JavaScript - obsługa -->

<script>
    // Wywołanie informacji o wybranym zadaniu
    $(document).on('click', ".btn-task", function() {
        var taskID = $(this).attr("id");
        $("#taskDet").load("templates/TreeDetails/selectedTaskDetails_tpl.php?taskID=" + taskID, function(responseTxt, statusTxt, xhr) {
            if (statusTxt == "error")
                alert("Błąd! Skontaktuj się z administratorem!");
        });
    });
</script>

<?php
unset($myTasks);
unset($otherTasks);
