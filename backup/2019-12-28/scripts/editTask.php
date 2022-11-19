<?php

require_once '../entryPoint.php';
require_once '../class/Task.php';

// var_dump($_POST);

$taskDetails = [
    'taskID' => $_POST['taskID'],
    'taskNumber' => $_POST['taskNumber'],
    'taskTree' => $_POST['taskTree'],
    'taskGroup' => $_POST['taskGroup'],
    'taskType' => $_POST['taskType'],
    'taskMy' => intval($_POST['taskMy']),
];

$status =  Task::updateTask($db_connect, $taskDetails);

if ($status) {
    $alertStyle = "alert alert-success shadow";
    $statusMsg = "Operacja zakończona powodzeniem, dane zostały zapisane w bazie!";
} else {
    $alertStyle = "alert alert-danger shadow";
    $statusMsg = "Błąd, skontaktuj się z administratorem!";
}

?>



<div class="<?= $alertStyle ?>" role="alert" style="height:340px;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="alert-heading">Sukces</h4>
    <p><?= $statusMsg ?></p>
    <hr>
    <p class="mb-0">
        <table>
            <tbody class="table table-sm table-bordered">
                <tr>
                    <td>Numer zadania</td>
                    <td><?= $taskDetails['taskNumber'] ?></td>
                </tr>
                <tr>
                    <td>Drzewo zadań</td>
                    <td><?= $taskDetails['taskTree'] ?></td>
                </tr>
                <tr>
                    <td>Faza wykonania</td>
                    <td><?= $taskDetails['taskType'] ?></td>
                </tr>
                <tr>
                    <td>Grupa wsparcia</td>
                    <td><?= $taskDetails['taskGroup'] ?></td>
                </tr>
                <tr>
                    <td>Moje zadanie</td>
                    <td><?php
                        if ($taskDetails['taskMy'] == 1) {
                            echo 'TAK';
                        } else {
                            echo 'NIE';
                        }
                        ?></td>
                </tr>
            </tbody>



        </table>




    </p>
</div>