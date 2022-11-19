<?php

/**
 * Formularz dodawania drzewa
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';
require_once '../../class/Dictionary.php';

//Pobieranie listy drzew
$treesList = Tree::getTreesList($db_connect);

// 003.TreeEnvDict
$TreeEnvDictionary = Dictionary::getSelectedDictionaryValues($db_connect, "A003");

$TreeEnvDict = '';

if (!empty($TreeEnvDictionary)) {
    for ($i = 0; $i < count($TreeEnvDictionary); $i++) {
        $TreeEnvDict .= '<option>' . $TreeEnvDictionary[$i]['value'] . '</option>';
    }
}



$TaskTreeList = '';

if (!empty($treesList)) {
    for ($i = 0; $i < count($treesList); $i++) {
        $TaskTreeList .= '<option value="' . $treesList[$i]['id'] . '">' . $treesList[$i]['TreeName'] . '</option>';
    }
}

?>

<!-- ZAWARTOŚĆ GRAFICZNA -->

<div class="container" style="margin-top: 2%;">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="shadow-lg card text-center bg-primary text-light">
                <h2 style="text-align: center;">Drzewa zadań</h2>
            </div>
            <hr>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div id="odp"></div>
        </div>
    </div>
    <div id="coppyTree" class="row justify-content-center">
        <div class="col-sm-8">
            <div id="accordion">
                <div class="card">
                    <div class="card-header border border-dark" id="headingOne">
                        <h5 class="mb-0">
                            <button style="width:100%;" class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Tworzenie nowego drzewa
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body border border-primary">
                            <form method="GET" id="addNewTreeForm">
                                <table class="table table-sm">
                                    <thead style="font-size: 14px;">
                                        <tr>
                                            <td colspan="2">
                                                <input type="text" class="form-control form-control-sm" id="addTreeName" name="addTreeName" placeholder="Wprowadź nazwę nowego drzewa">
                                            </td>
                                            <td colspan="1">
                                                <select id="TreeEnv" name="TreeEnv" class="form-control form-control-sm">
                                                    <?= $TreeEnvDict ?>
                                                </select>
                                            </td>
                                            <td align="center">
                                                <input id="addTreeSubmit" type="button" name="addTreeSubmit" value="➕" class="btn btn-primary btn-sm" style="width: 100%">
                                            </td>
                                        </tr>
                                        <?php
                                        if (isset($treesList)) {
                                        ?>
                                            <tr>
                                                <td colspan="1" style="vertical-align:bottom;">Nazwa</td>
                                                <td colspan="1" style="vertical-align:bottom;">Środowisko</td>
                                                <td colspan="1" style="vertical-align:bottom;">Data utworzenia</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" id="delsel" style="width: 100%;"> Usuń zaznaczone </button></td>
                                            </tr>
                                        <?php

                                        }
                                        ?>
                                    </thead>
                                    <tbody style="font-size: 14px;">
                                        <?php
                                        if (isset($treesList)) {
                                        ?>
                                            <?php
                                            for ($i = 0; $i < count($treesList); $i++) {
                                            ?>
                                                <tr>
                                                    <td style="text-align: left;" colspan="1"><?= $treesList[$i]['TreeName'] ?></td>
                                                    <td style="text-align: left;" colspan="1"><?= $treesList[$i]['TreeEnv'] ?></td>
                                                    <td colspan="1"><?= $treesList[$i]['CreateDateTime'] ?></td>
                                                    <td colspan="1" style="text-align: center;"><input type="checkbox" class="checkitem" value="<?= $treesList[$i]['id'] ?>" /></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <form action="scripts/NewTree/copyTree_spt.php" method="post" id="copyTree_form">
                    <div class="card shadow-lg">
                        <div class="card-header border border-dark" id="headingTwo">
                            <h5 class="mb-0">
                                <button type="button" style="width:100%;" class="btn btn-outline-primary collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Kopiowanie drzewa
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body border border-primary">
                                <form action="" method="post" id="copyTree_form">
                                    <div class="form-row" style="font-size: 14px;">
                                        <div class="form-group col-md-12">
                                            <select id="CloneTree" name="CloneTree" class="form-control form-control-sm">
                                                <option value=""> -- wybierz drzewo --</option>
                                                <?= $TaskTreeList ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="CloneForm"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


<!-- JavaScript - obsługa -->

<script>
    $(document).ready(function() {

        //obsługa przycisku dodawania drzewa
        $('#addTreeSubmit').click(function() {
            document.getElementById("addTreeSubmit").disabled = true;
            document.getElementById("addTreeSubmit").value = "......";
            //formularz
            $.ajax({
                url: "scripts/NewTree/addNewTree_spt.php",
                method: "POST",
                data: $('#addNewTreeForm').serialize(),
                success: function(data) {
                    document.getElementById("addTreeSubmit").disabled = false;
                    document.getElementById("addTreeSubmit").value = "Ponów próbę...";
                    document.getElementById("odp").innerHTML = data;
                    if (data == '') {
                        $("#main").load("templates/NewTree/ManageTrees_tpl.php", function(responseTxt, statusTxt, xhr) {
                            if (statusTxt == "error")
                                alert("Błąd! Skontaktuj się z administratorem!");
                        });
                    }
                }
            });
        });

        //Obsługa przycisku usuwania drzewa
        $('#delsel').click(function() {
            document.getElementById("delsel").disabled = true;
            document.getElementById("delsel").value = "......";
            var id = $('.checkitem:checked').map(function() {
                return $(this).val()
            }).get().join(',');
            $("#odp").load("scripts/NewTree/deleteTree_spt.php?deleteTree=" + id, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "success")
                    document.getElementById("delsel").disabled = false;
                if (responseTxt == '') {
                    $("#main").load("templates/NewTree/ManageTrees_tpl.php", function(responseTxt, statusTxt, xhr) {
                        if (statusTxt == "error")
                            alert("Błąd! Skontaktuj się z administratorem!");
                    });
                }
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });


        //Ładowanie zadań wybranego drzewa (dodatek do formularza, umożliwiający powiązanie z istniejącymi już zadaniami)
        $('#CloneTree').change(function() {

            // alert($(this).val());

            $("#CloneForm").load("templates/NewTree/CloneTree_tpl.php?tree=" + $(this).val(), function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });

    });
</script>


<script>
    //Obsługa formularza dodawania zadania
    $("#copyTree_form").submit(function(event) {
        document.getElementById("copy_save").disabled = true;
        document.getElementById("copy_save").value = "Przetwarzanie...";
        event.preventDefault(); //prevent default action 
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission
        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data
        }).done(function(response) {
            document.getElementById("copy_save").disabled = false;
            document.getElementById("copy_save").value = "Utwórz kopię";
            document.getElementById("odp").innerHTML = response;
            if (response.includes("success")) {
                document.getElementById("my_form").reset();
            }
        });
    });
</script>