<?php
require_once '../entryPoint.php';
require_once '../class/Tree.php';
require_once '../class/Dictionary.php';

$treesList = Tree::getTreesList($db_connect);

// 003.TreeEnvDict

$TreeEnvDictionary = Dictionary::getSelectedDictionaryValues($db_connect, "A003");

$TreeEnvDict = '';

if (!empty($TreeEnvDictionary)) {
    for ($i = 0; $i < count($TreeEnvDictionary); $i++) {
        $TreeEnvDict .= '<option>' . $TreeEnvDictionary[$i]['value'] . '</option>';
    }
}

?>
<div class="container" style="margin-top: 2%;">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="shadow card text-center bg-primary text-light">
                <h2 style="text-align: center;">Drzewa zadań</h2>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <hr>
            <div class="shadow card">
                <div class="card-body">
                    <form method="GET" id="addNewTreeForm">
                        <table class="table table-sm">
                            <tbody style="font-size: 14px;">
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
    </div>

    <div id="odp"></div>

    <script>
        $('#addTreeSubmit').click(function() {
            document.getElementById("addTreeSubmit").disabled = true;
            document.getElementById("addTreeSubmit").value = "......";

            $.ajax({
                url: "scripts/addNewTree_spt.php",
                method: "POST",
                data: $('#addNewTreeForm').serialize(),
                success: function(data) {
                    $("#main").load("templates/ManageTrees_tpl.php", function(responseTxt, statusTxt, xhr) {
                        if (statusTxt == "error")
                            alert("Błąd! Skontaktuj się z administratorem!");
                    });
                }
            });
        });

        $('#delsel').click(function() {
            document.getElementById("delsel").disabled = true;
            document.getElementById("delsel").value = "......";
            var id = $('.checkitem:checked').map(function() {
                return $(this).val()
            }).get().join(',');
            $("#odp").load("scripts/deleteTree_spt.php?deleteTree=" + id, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "success")
                    $("#main").load("templates/ManageTrees_tpl.php", function(responseTxt, statusTxt, xhr) {
                        if (statusTxt == "error")
                            alert("Błąd! Skontaktuj się z administratorem!");
                    });
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });
    </script>