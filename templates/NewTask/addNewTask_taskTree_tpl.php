<?php

/**
 * Część formularza z istniejącymi już zadaniami
 * ©Copyright 2019
 * Karol Osica
 */
require_once '../../entryPoint.php';
require_once '../../class/Task.php';
require_once '../../class/Tree.php';

//Pobieranie listy zadań wybranego drzewa
$selectedTaskTrees = Tree::getTasksList($db_connect, $_REQUEST['tree']);

//Tworzenie dwóch list (blokowanych i blkoujących)
if (is_array($selectedTaskTrees) && !empty($selectedTaskTrees)) {
    $selectedTaskTreesTableBlocks = '';
    for ($i = 0; $i < count($selectedTaskTrees); $i++) {
        $selectedTaskTreesTableBlocks .=  '<tr>';
        $selectedTaskTreesTableBlocks .=  '<td>
        <div class="form-check">
        <input id="blocks_' . $selectedTaskTrees[$i]['id'] . '" class="form-check-input checkitem_blocks" type="checkbox" value="' . $selectedTaskTrees[$i]['id'] . '">
        <label class="form-check-label" for="blocks_' . $selectedTaskTrees[$i]['id'] . '">
        ' . $selectedTaskTrees[$i]['TaskNumber'] . '
        </label>
        </div>  
        </td>';
        $selectedTaskTreesTableBlocks .=  '</tr>';
    }

    $selectedTaskTreesTableBlocked = '';
    for ($i = 0; $i < count($selectedTaskTrees); $i++) {
        $selectedTaskTreesTableBlocked .=  '<tr>';
        $selectedTaskTreesTableBlocked .=  '<td>
        <div class="form-check">
            <input id="blocked_' . $selectedTaskTrees[$i]['id'] . '" class="form-check-input checkitem_blocked" type="checkbox" value="' . $selectedTaskTrees[$i]['id'] . '">
            <label class="form-check-label" for="blocked_' . $selectedTaskTrees[$i]['id'] . '">
            ' . $selectedTaskTrees[$i]['TaskNumber'] . '
            </label>
        </div>
        </td>';
        $selectedTaskTreesTableBlocked .=  '</tr>';
    }
?>

    <!-- ZAWARTOŚĆ GRAFICZNA -->

    <div class="row justify-content-center">
        <div class="form-row" style="font-size: 14px;">
            <hr>
            <table class="table table-sm table-hover" id="selectedTaskTreesTable">
                <thead>
                    <tr style="border-top: 3px solid white;">
                        <th colspan="6" style="text-align: center; width: 100%">Zadanie przypisane do wybranego drzewa:</th>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center; font-size: 10px;"><i>Aby dodać relacje, wybierz zadania z listy poniżej</i></td>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align: left; width: 50%;">Dodawane zadanie blokuje:</th>
                        <th colspan="3" style="text-align: left;">Dodawane zadanie jest blokowane przez:</th>
                    </tr>
                </thead>
            </table>
            <div class="col-sm-6">
                <div style="width: 100%; height: 150px; overflow-y: scroll;">
                    <table class="table table-sm table-hover" id="selectedTaskTreesTable">
                        <tbody>
                            <?= $selectedTaskTreesTableBlocks ?>
                        <tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-6">
                <div style="width: 100%; height: 150px; overflow-y: scroll;">
                    <table class="table table-sm table-hover" id="selectedTaskTreesTable">
                        <tbody>
                            <?= $selectedTaskTreesTableBlocked ?>
                        <tbody>
                    </table>
                </div>
            </div>
            <input type="text" id="selectedBlocksTasks" name="selectedBlocksTasks" hidden />
            <input type="text" id="selectedBlockedTasks" name="selectedBlockedTasks" hidden />
        </div>
    </div>

    <!-- JavaScript - obsługa -->

    <script>
        $(document).ready(function() {
            //zliczanie zaznaczonych opcji na formularzy
            $('#saveTasks').click(function() {
                var id_blocks = $('.checkitem_blocks:checked').map(function() {
                    return $(this).val()
                }).get().join(',');
                var id_blocked = $('.checkitem_blocked:checked').map(function() {
                    return $(this).val()
                }).get().join(',');
                document.getElementById("selectedBlocksTasks").value = id_blocks;
                document.getElementById("selectedBlockedTasks").value = id_blocked;
            });
        });
    </script>
<?php
}
?>