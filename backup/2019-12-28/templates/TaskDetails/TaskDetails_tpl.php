<?php
require_once '../../entryPoint.php';
require_once '../../class/Task.php';
$task = null;
if (isset($_GET['taskID'])) {
    $task = new Task($db_connect, $_GET['taskID']);
}

?>

<div class="shadow card">
    <div class="card-header bg-secondary text-center">
        <font size="5" class="text-light"><b><?= $task->TaskNumber ?></b></font>
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

                            <button name="taskDone" id="<?= $task->id ?>" type="button" class="btn btn-sm btn-danger taskDone" style="width: 100%">Zamknij zadanie</button>
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

            </tbody>
        </table>
    </div>
</div>


<script>
    //przycisk zamknij zadanie
    $(document).on('click', ".taskDone", function() {
        var taskDone = $(this).attr("id");
        var now = new Date();
        var dateNow = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();

        $("#process").load("scripts/setDoneStatus_Task.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
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

        $("#process").load("scripts/unsetDoneStatus_Task.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
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


    //przycisk otwórz zadanie
    $(document).on('click', ".taskEdit", function() {
        var taskDone = $(this).attr("id");

        var selectedButton = document.getElementsByClassName("taskEdit")[0]
        selectedButton.classList = "btn btn-sm btn-outline-info taskEdit";
        selectedButton.disabled = true;
        selectedButton.innerHTML = "W trakcie edytowania";

        $("#taskFormTASK").load("templates/TaskDetails/TaskForm_tpl.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {





        });

        // $("#process").load("scripts/unsetDoneStatus_Task.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
        //     if (statusTxt == "success")
        //         var selectedButton = document.getElementsByClassName("taskOpen")[0]
        //     selectedButton.classList = "btn btn-sm btn-danger taskDone";
        //     selectedButton.innerHTML = "Zamknij zadanie";
        //     document.getElementById("ifDone").innerHTML = "NIE";
        //     document.getElementById("DoneDate").innerHTML = dateNow;


        //     if (statusTxt == "error")
        //         alert("Błąd! Skontaktuj się z administratorem!");

        // });
    });
</script>