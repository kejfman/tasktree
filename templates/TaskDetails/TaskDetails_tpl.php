<?php

/**
 * Formularz - dane szczegółowe na temat wybranego zadania
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Task.php';

$task = null;
if (isset($_GET['taskID'])) { //tworzenie obiektu Task
    $taskID = explode("_", $_GET['taskID']);
    $taskID = $taskID[1];
    $task = new Task($db_connect,  $taskID);
}
?>

<!-- CZĘŚĆ GRAFICZNA -->

<div class="shadow-lg card border border-primary">
    <div class="card-header bg-light text-center">
        <font size="5" class="text-dark"><b><?= $task->TaskNumber ?></b></font>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm" style="font-size: 12px;">
            <tbody>
                <tr>
                    <td width="30%">Faza wykonania</td>
                    <td id="taskType_details"><?= $task->TaskType ?></td>
                </tr>
                <tr>
                    <td width="30%">Grupa wsparcia</td>
                    <td><?= $task->TaskOwner ?></td>
                </tr>
                <tr>
                    <td width="30%">Utworzono</td>
                    <td><?= $task->CreateDateTime ?></td>
                </tr>
                <tr>
                    <td width="30%">Moje zadanie</td>
                    <td id="MyT"><?php
                                    if ($task->MyTask == '1') {
                                        echo "TAK";
                                    } else {
                                        echo "NIE";
                                    } ?></td>
                </tr>
                <tr>
                    <td width="30%">Czy zamknięte</td>
                    <td id="doneCheck"><?php
                                        if ($task->Done == '1') {
                                            echo "TAK";
                                        } else {
                                            echo "NIE";
                                        } ?></td>
                </tr>
                <tr>
                    <td width="30%">Data zamknięcia</td>
                    <td id="DoneDate"><?= $task->DoneDateTime ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        if ($task->Done == 1) {
                        ?>
                            <button name="taskDone" id="<?= $task->id ?>" type="button" class="btn btn-sm btn-success taskOpen" style="width: 100%">Otwórz zadanie</button>
                        <?php
                        } else {
                        ?>
                            <button name="taskDone" id="<?= $task->id ?>" type="button" class="btn btn-sm btn-warning taskDone" style="width: 100%">Zamknij zadanie</button>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button name="taskDone" id="<?= $task->id ?>" type="button" class="btn btn-sm btn-info taskEdit" style="width: 100%">Edytuj</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button name="taskDelete" id="<?= $task->id ?>" type="button" class="btn btn-sm btn-danger taskDelete" style="width: 100%">Usuń</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript - obsługa -->

<script>
    //przycisk usuń zadanie
    $(document).on('click', ".taskDelete", function() {
        var taskID = $(this).attr("id");
        $("#taskDetailsTASK").load("scripts/ManageTasks/deleteTask.php?taskID=" + taskID, function(responseTxt, statusTxt, xhr) {
            document.getElementById("taskFormTASK").innerHTML = "";
            document.getElementById("btn_" + taskID).innerHTML = "Usunięto";
            document.getElementById("btn_" + taskID).disabled = true;
            document.getElementById("btn_" + taskID).classList = "btn btn-sm btn-dark";
            document.getElementById("tr_" + taskID).hidden = true;
            if (statusTxt == "error")
                alert("Błąd! Skontaktuj się z administratorem!");

        });
    });

    //przycisk zamknij zadanie
    $(document).on('click', ".taskDone", function() {
        var taskDone = $(this).attr("id");
        var now = new Date();
        var dateNow = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
        $("#process").load("scripts/ManageTasks/setDoneStatus_Task.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
            if (statusTxt == "success")
                var selectedButton = document.getElementsByClassName("taskDone")[0];
            selectedButton.classList = "btn btn-sm btn-success taskOpen";
            selectedButton.innerHTML = "Otwórz zadanie";
            document.getElementById("doneCheck").innerHTML = "TAK";
            document.getElementById("DoneDate").innerHTML = dateNow;
            if (statusTxt == "error")
                alert("Błąd! Skontaktuj się z administratorem!");

        });
    });

    //przycisk otwórz zadanie
    $(document).on('click', ".taskOpen", function() {
        var taskDone = $(this).attr("id");
        var now = new Date();
        var dateNow = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
        $("#process").load("scripts/ManageTasks/unsetDoneStatus_Task.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
            if (statusTxt == "success")
                var selectedButton = document.getElementsByClassName("taskOpen")[0];
            selectedButton.classList = "btn btn-sm btn-danger taskDone";
            selectedButton.innerHTML = "Zamknij zadanie";
            document.getElementById("doneCheck").innerHTML = "NIE";
            document.getElementById("DoneDate").innerHTML = dateNow;
            if (statusTxt == "error")
                alert("Błąd! Skontaktuj się z administratorem!");
        });
    });

    //Przycisk edytuj zadanie
    $(document).on('click', ".taskEdit", function() {
        var taskDone = $(this).attr("id");
        var selectedButton = document.getElementsByClassName("taskEdit")[0]
        selectedButton.classList = "btn btn-sm btn-outline-info taskEdit";
        selectedButton.disabled = true;
        selectedButton.innerHTML = "W trakcie edytowania";
        $("#taskFormTASK").load("templates/TaskDetails/TaskForm_tpl.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
            if (statusTxt == "error")
                alert("Błąd! Skontaktuj się z administratorem!");
        });
    });
</script>