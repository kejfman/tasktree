<?php

/**
 * Formularz dodawania nowego zadania
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';
require_once '../../class/Dictionary.php';

//przygotowanie słowników

// TaskTreeList

$treeList = Tree::getTreesList($db_connect);

$TaskTreeList = '';

if (!empty($treeList)) {
    for ($i = 0; $i < count($treeList); $i++) {
        $TaskTreeList .= '<option value="' . $treeList[$i]['id'] . '">' . $treeList[$i]['TreeName'] . '</option>';
    }
}

// 001.TaskTypeDict
$TaskTypeDictionary = Dictionary::getSelectedDictionaryValues($db_connect, "A001");

$TaskTypeDict = '';

if (!empty($TaskTypeDictionary)) {
    for ($i = 0; $i < count($TaskTypeDictionary); $i++) {
        $TaskTypeDict .= '<option>' . $TaskTypeDictionary[$i]['value'] . '</option>';
    }
}

// 002.TaskOwnerDict
$TaskOwnerDictionary = Dictionary::getSelectedDictionaryValues($db_connect, "A002");

$TaskOwnerDict = '';

if (!empty($TaskOwnerDictionary)) {
    for ($i = 0; $i < count($TaskOwnerDictionary); $i++) {
        $TaskOwnerDict .= '<option>' . $TaskOwnerDictionary[$i]['value'] . '</option>';
    }
}

?>

<!-- CZĘŚĆ WIZUALNA -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="shadow-lg card text-center bg-primary text-light">
                <h2 style="text-align: center;">Nowe zadanie</h2>
            </div>
            <hr>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div id="odp"></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="shadow-lg card border border-primary">
                <div class="card-body">
                    <form action="scripts/NewTask/createNewTask.php" method="post" id="my_form">
                        <div class="form-row" style="font-size: 14px;">
                            <div class="form-group col-md-12">
                                <label for="TaskTree">Drzewo zadań</label>
                                <select id="TaskTree" name="TaskTree" class="form-control form-control-sm">
                                    <option value=""> -- wybierz drzewo --</option>
                                    <?= $TaskTreeList ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row" style="font-size: 14px;">
                            <table class="table table-sm" id="aaa" style="font-size: 14px;">
                                <tr style="border-top: 3px solid white; border-bottom: 2px solid lightgray;">
                                    <td colspan="1" style="vertical-align:bottom; width: 30%">Numer zadania</td>
                                    <td colspan="1" style="vertical-align:bottom;">Faza wykonania</td>
                                    <td colspan="1" style="vertical-align:bottom;">Grupa wsparcia</td>
                                    <td colspan="1" style="vertical-align:bottom; text-align:center;">Moje</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="TaskNumber" name="TaskNumber">
                                    </td>
                                    <td>
                                        <select id="TaskType" name="TaskType" class="form-control form-control-sm">
                                            <?= $TaskTypeDict ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="TaskOwner" name="TaskOwner" class="form-control form-control-sm">
                                            <?= $TaskOwnerDict ?>
                                        </select>
                                    </td>
                                    <td style="vertical-align:bottom; text-align:center;">
                                        <input type="checkbox" id="MyTask" name="MyTask" checked />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-row" id="BlocksRowDiv" style="font-size: 14px;">
                            <table class="table table-sm" id="BlocksRow">
                                <thead>
                                    <tr style="border-top: 3px solid white;">
                                        <th colspan="5" style="text-align: center;">Zadanie blokuje:</th>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: center; font-size: 10px;"><i>Aby dodać zadanie, naciśnij przycisk ➕</i></td>
                                    </tr>
                                    <tr style="border-bottom: 2px solid lightgray;">
                                        <td colspan="1" style="vertical-align:bottom; width: 30%">Numer zadania</td>
                                        <td colspan="1" style="vertical-align:bottom;">Faza wykonania</td>
                                        <td colspan="2" style="vertical-align:bottom;">Grupa wsparcia</td>
                                        <td>
                                            <button id="addBlocksRow" type="button" class="btn btn-sm btn-outline-success" style="width: 100%;">➕</button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <br />
                        <div class="form-row" id="BlocksRowDiv" style="font-size: 14px;">
                            <table class="table table-sm" id="BlockedRow">
                                <thead>
                                    <tr style="border-top: 3px solid white;">
                                        <th colspan="5" style="text-align: center;">Zadanie jest blokowane przez:</th>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: center; font-size: 10px;"><i>Aby dodać zadanie, naciśnij przycisk ➕</i></td>
                                    </tr>
                                    <tr style="border-bottom: 2px solid lightgray;">
                                        <td colspan="1" style="vertical-align:bottom; width: 30%">Numer zadania</td>
                                        <td colspan="1" style="vertical-align:bottom;">Faza wykonania</td>
                                        <td colspan="2" style="vertical-align:bottom;">Grupa wsparcia</td>
                                        <td>
                                            <button id="addBlockedRow" type="button" class="btn btn-sm btn-outline-success" style="width: 100%;">➕</button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <br />
                        <div class="col-sm-12" id="selectedTreeTasks">
                        </div>
                        <br />
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="submit" id="saveTasks" class="btn btn-sm btn-secondary" style="width: 100%;" name="submit" value="Zapisz" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="server-results"></div>

<!-- JavaScript - obsługa -->

<script>
    $(document).ready(function() {

        //Dodawanie wiersza z zadaniami blokowanymi
        var i = 0;
        $('#addBlocksRow').click(function() {
            $('#BlocksRow').append('<tr id="BlocksRow' + i + '"><td><input type="text" class="form-control form-control-sm" id="TaskNumberBlocks' + i + '" name="TaskNumberBlocks[]"></td><td><select id="TaskTypeBlocks' + i + '" name="TaskTypeBlocks[]" class="form-control form-control-sm"><?= $TaskTypeDict ?></select></td><td colspan="2"><select id="TaskOwnerBlocks' + i + '" name="TaskOwnerBlocks[]" class="form-control form-control-sm"><?= $TaskOwnerDict ?></select></td><td><button id="' + i + '" type="button" class="btn btn-sm btn-outline-danger btn_remove" style="width: 100%;">➖</button></td></tr>');
            i++;
        });

        //Usuwanie wiersza z zadaniami blokowanymi
        $(document).on('click', ".btn_remove", function() {
            var button_id = $(this).attr("id");
            $('#BlocksRow' + button_id + '').remove();
        });

        //DOdawanie wiersza z zadaniami blokującymi
        var j = 0;
        $('#addBlockedRow').click(function() {

            $('#BlockedRow').append('<tr id="BlockedRow' + j + '"><td><input type="text" class="form-control form-control-sm" id="TaskNumberBlocked' + j + '" name="TaskNumberBlocked[]"></td><td><select id="TaskTypeBlocked' + j + '" name="TaskTypeBlocked[]" class="form-control form-control-sm"><?= $TaskTypeDict ?></select></td><td colspan="2"><select id="TaskOwnerBlocked' + j + '" name="TaskOwnerBlocked[]" class="form-control form-control-sm"><?= $TaskOwnerDict ?></select></td><td><button id="' + j + '" type="button" class="btn btn-sm btn-outline-danger btn_remove_blocked" style="width: 100%;">➖</button></td></tr>');
            j++;
        });

        //Usuwanie wiersza z zadaniami blokującymi
        $(document).on('click', '.btn_remove_blocked', function() {
            var button_id = $(this).attr("id");
            $('#BlockedRow' + button_id + '').remove();
        });

        //Obsługa formularza dodawania zadania
        $("#my_form").submit(function(event) {
            document.getElementById("saveTasks").disabled = true;
            document.getElementById("saveTasks").value = "Przetwarzanie...";
            event.preventDefault(); //prevent default action 
            var post_url = $(this).attr("action"); //get form action url
            var request_method = $(this).attr("method"); //get form GET/POST method
            var form_data = $(this).serialize(); //Encode form elements for submission
            $.ajax({
                url: post_url,
                type: request_method,
                data: form_data
            }).done(function(response) {
                document.getElementById("saveTasks").disabled = false;
                document.getElementById("saveTasks").value = "Zapisz";
                document.getElementById("odp").innerHTML = response;
                if (response.includes("success")) {
                    document.getElementById("my_form").reset();
                }
            });
        });

        //Ładowanie zadań wybranego drzewa (dodatek do formularza, umożliwiający powiązanie z istniejącymi już zadaniami)
        $('#TaskTree').change(function() {
            $("#selectedTreeTasks").load("templates/NewTask/addNewTask_taskTree_tpl.php?tree=" + $(this).val(), function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        })
    });
</script>