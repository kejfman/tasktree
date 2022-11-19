<?php

/**
 * Formularz edycji danych wybranego zadania
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Task.php';
require_once '../../class/Tree.php';
require_once '../../class/Dictionary.php';

//Tworzenie obiektu wybranego zadania
$sTask = new Task($db_connect, $_GET['taskID']);



// Obsługa słowników:

// TaskTreeList
$treeList = Tree::getTreesList($db_connect);
$TaskTreeList = '';
if ($sTask->TaskTree == '') {
    $TaskTreeList .= '<option selected value="">-- nie przypisano --</option>';
} else {
    $TaskTreeList .= '<option value="">-- nie przypisano --</option>';
}
if (!empty($treeList)) {
    for ($i = 0; $i < count($treeList); $i++) {
        if ($treeList[$i]['id'] == $sTask->TaskTree) {
            $TaskTreeList .= '<option selected value="' . $treeList[$i]['id'] . '">' . $treeList[$i]['TreeName'] . '</option>';
        } else {
            $TaskTreeList .= '<option value="' . $treeList[$i]['id'] . '">' . $treeList[$i]['TreeName'] . '</option>';
        }
    }
}

// 001.TaskTypeDict
$TaskTypeDictionary = Dictionary::getSelectedDictionaryValues($db_connect, "A001");
$TaskTypeDict = '';
if (!empty($TaskTypeDictionary)) {
    $TaskTypeDict .= '<option selected>' . $sTask->TaskType . '</option>';
    for ($i = 0; $i < count($TaskTypeDictionary); $i++) {
        if ($TaskTypeDictionary[$i]['value'] == $sTask->TaskType) {
            continue;
        }
        $TaskTypeDict .= '<option>' . $TaskTypeDictionary[$i]['value'] . '</option>';
    }
}

// 002.TaskOwnerDict
$TaskOwnerDictionary = Dictionary::getSelectedDictionaryValues($db_connect, "A002");
$TaskOwnerDict = '';
if (!empty($TaskOwnerDictionary)) {
    $TaskOwnerDict .= '<option selected>' . $sTask->TaskOwner . '</option>';
    for ($i = 0; $i < count($TaskOwnerDictionary); $i++) {
        if ($TaskOwnerDictionary[$i]['value'] == $sTask->TaskOwner) {
            continue;
        }
        $TaskOwnerDict .= '<option>' . $TaskOwnerDictionary[$i]['value'] . '</option>';
    }
}


//Czy moje zadanie
$TaskMyDict = '';
if ($sTask->MyTask == 1) {
    $TaskMyDict = '
    <option selected value="1">TAK</option>
    <option value="0">NIE</option>
    ';
} else {
    $TaskMyDict = '
    <option value="0" selected>NIE</option>
    <option value="1">TAK</option>
    ';
}
?>

<!-- CZĘŚĆ GRAFICZNA -->

<div class="shadow-lg card border border-primary">
    <div class="card-body">
        <form action="scripts/ManageTasks/editTask.php" method="post" id="edit_form">
            <div class="form-group" hidden>
                <label for="taskID">ID zadania</label>
                <input type="text" class="form-control form-control-sm" id="taskID" name="taskID" value="<?= $sTask->id ?>" readonly>
            </div>
            <div class="form-group">
                <label for="taskNumber">Numer zadania</label>
                <input type="text" class="form-control form-control-sm" id="taskNumber" name="taskNumber" value="<?= $sTask->TaskNumber ?>" readonly>
            </div>
            <div class="form-group">
                <label for="taskTree">Drzewo zadań</label>
                <select class="custom-select custom-select-sm" id="taskTree" name="taskTree">
                    <?= $TaskTreeList ?>
                </select>
            </div>
            <div class="form-group">
                <label for="taskGroup">Grupa właścicielska</label>
                <select class="custom-select custom-select-sm" id="taskGroup" name="taskGroup">
                    <?= $TaskOwnerDict ?>
                </select>
            </div>
            <div class="form-group">
                <label for="taskType">Faza wykonania</label>
                <select class="custom-select custom-select-sm" id="taskType" name="taskType">
                    <?= $TaskTypeDict ?>
                </select>
            </div>
            <div class="form-group">
                <label for="taskMy">Moje zadanie</label>
                <select class="custom-select custom-select-sm" id="taskMy" name="taskMy">
                    <?= $TaskMyDict ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" id="saveChanges" class="btn btn-sm btn-success" style="width: 100%;" name="submit" value="Zapisz zmiany" />
                <button name="cancel" id="cancel" type="button" class="btn btn-sm btn-danger" style="width: 100%; margin-top: 10px;">Anuluj</button>
            </div>

        </form>

    </div>
</div>

<!-- JavaScript - obsługa -->

<script>
    var taskID = "btn_<?= $sTask->id ?>";
    var treeID = "<?= $sTask->TaskTree ?>";

    //obsługa formularza edycji danych wybranego zadania
    $("#edit_form").submit(function(event) {
        document.getElementById("saveChanges").disabled = true;
        document.getElementById("saveChanges").value = "Przetwarzanie...";
        event.preventDefault(); //prevent default action 
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission
        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data
        }).done(function(response) {
            $("#taskFormTASK").html(response);

            var selectedButton = document.getElementsByClassName("taskEdit")[0]
            selectedButton.classList = "btn btn-sm btn-info taskEdit";
            selectedButton.disabled = false;
            selectedButton.innerHTML = "Edytuj";
            $("#taskDetailsTASK").load("templates/TaskDetails/TaskDetails_tpl.php?taskID=" + taskID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "success")
                    $("#taskListTASK").load("templates/TaskDetails/TaskList_tpl.php?treeID=" + treeID, function(responseTxt, statusTxt, xhr) {
                        if (statusTxt == "error")
                            alert("Błąd! Skontaktuj się z administratorem!");
                    });
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });
    });

    //obsługa przycisku anuluj
    $('#cancel').click(function() {
        var selectedButton = document.getElementsByClassName("taskEdit")[0]
        selectedButton.classList = "btn btn-sm btn-info taskEdit";
        selectedButton.disabled = false;
        selectedButton.innerHTML = "Edytuj";
        $("#taskFormTASK").html("");

    });
</script>