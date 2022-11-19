<?php
require_once '../../entryPoint.php';
require_once '../../class/Task.php';

$task = new Task($db_connect, $_GET['taskID']);

?>


<div class="shadow card">
    <div class="card-header bg-secondary text-center">
        <font size="5" class="text-light"><?= $task->TaskNumber ?></font>
    </div>
    <div class="card-body">
        <div class="form-row" style="font-size: 14px;">
            <div class="form-group col-md-12">

                TODO: Formularz do zmiany danych wybranego zadania !

            </div>
        </div>
    </div>
</div>