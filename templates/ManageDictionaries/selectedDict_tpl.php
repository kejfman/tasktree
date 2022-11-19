<?php

/**
 * Rekordy wybranego słownika
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Dictionary.php';

if (isset($_REQUEST['dict'])) { //sprawdzanie czy został wybrany słownik
    //Pobieranie danych wybranego słownika
    $dict_content = Dictionary::getSelectedDictionaryValues($db_connect, $_REQUEST['dict']);
} else { //wyłączenie w przypadku braku wybranego słownika
    exit;
}
?>

<!-- WYGLĄD -->

<div class="shadow-lg card border border-primary">
    <div class="card-header bg-light text-center">
        <font size="5" class="text-dark">Wybrany słownik</font>
    </div>
    <div class="card-body">
        <?php
        if ($_GET['dict'] != '') {
        ?>
            <form action="scripts/ManageDictionaries/manageDictionaries.php" method="GET" id="my_form">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <th scope="row">✒</th>
                            <td>
                                <input id="dict" name="dict" type="text" value="<?= $_REQUEST['dict'] ?>" hidden>
                                <input id="add" name="add" type="text" value="" hidden>
                                <input type="text" class="form-control form-control-sm" id="value" name="value" placeholder="Wprowadź wartość" autofocus>
                            </td>
                            <td align="right">
                                <button id="save_dict" type="submit" name="save_dict" class="btn btn-outline-success btn-sm">➕</button>
                                <button id="btn-delete" type="button" class="btn btn-outline-danger btn-sm" name="dict_delete">➖</button>
                            </td>
                        </tr>
                        <?php
                        if ($dict_content != null) {
                            foreach ($dict_content as $key => $value) {
                        ?>
                                <tr>
                                    <th scope="row"><?= $key ?></th>
                                    <td><label for="opt_<?= $value['id'] ?>"><?= $value['value'] ?></label></td>
                                    <td align="right">
                                        <input id="opt_<?= $value['id'] ?>" type="checkbox" class="checkitem" value="<?= $value['id'] ?>" style="margin-right: 12px;" />
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        <?php
        }
        ?>
    </div>
</div>
<br />
<div id="odp"></div>

<!-- JavaScript - obsługa  -->

<script>
    $(document).ready(function() {

        //obsługa formularza dodawania wpisu do słownika
        $("#my_form").submit(function(event) {
            document.getElementById("save_dict").disabled = true;
            document.getElementById("save_dict").innerHTML = "🔘";
            event.preventDefault(); //prevent default action 
            var post_url = $(this).attr("action"); //get form action url
            var request_method = $(this).attr("method"); //get form GET/POST method
            var form_data = $(this).serialize(); //Encode form elements for submission
            var dict = document.getElementById("dict").value;
            $.ajax({
                url: post_url,
                type: request_method,
                data: form_data
            }).done(function(response) {
                document.getElementById("save_dict").disabled = false;
                document.getElementById("save_dict").innerHTML = "➕";
                $("#odp").html(response);
                if (response == '') {
                    $("#selectedDict").load("templates/ManageDictionaries/selectedDict_tpl.php?dict=" + dict, function(responseTxt, statusTxt, xhr) {
                        if (statusTxt == "error")
                            alert("Błąd! Skontaktuj się z administratorem!");
                    });
                }
            });

        });

        //obsługa operacji usuwania wpisu ze słownika
        $('#btn-delete').click(function() {
            document.getElementById("btn-delete").disabled = true;
            document.getElementById("btn-delete").innerHTML = "🔘";
            var dictID = document.getElementById("dict").value;
            var id = $('.checkitem:checked').map(function() {
                return $(this).val()
            }).get().join(',');
            $("#odp").load("scripts/ManageDictionaries/manageDictionaries.php?dell&id=" + id, function(responseTxt, statusTxt, xhr) {
                document.getElementById("btn-delete").disabled = false;
                document.getElementById("btn-delete").innerHTML = "➖";
                if (statusTxt == "success")
                    if (responseTxt == '') {
                        $("#selectedDict").load("templates/ManageDictionaries/selectedDict_tpl.php?dict=" + dictID, function(responseTxt, statusTxt, xhr) {
                            if (statusTxt == "error")
                                alert("Błąd! Skontaktuj się z administratorem!");
                        });
                    }
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });
    });
</script>