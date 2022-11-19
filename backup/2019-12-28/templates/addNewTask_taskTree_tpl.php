<?php

require_once '../entryPoint.php';
require_once '../class/Task.php';
require_once '../class/Tree.php';

$selectedTaskTrees = Tree::getTasksList($db_connect, $_REQUEST['tree']);





if (is_array($selectedTaskTrees) && !empty($selectedTaskTrees)) {
    $selectedTaskTreesTableBlocks = '';
    for ($i = 0; $i < count($selectedTaskTrees); $i++) {
        $selectedTaskTreesTableBlocks .=  '<tr>';
        $selectedTaskTreesTableBlocks .=  '<td>' . $selectedTaskTrees[$i]['TaskNumber'] . '</td>';
        $selectedTaskTreesTableBlocks .=  '<td> <input id="' . $selectedTaskTrees[$i]['id'] . '" type="checkbox" class="checkitem_blocks" value="' . $selectedTaskTrees[$i]['id'] . '" style="margin-right: 12px;" /></td>';
        $selectedTaskTreesTableBlocks .=  '</tr>';
    }

    $selectedTaskTreesTableBlocked = '';
    for ($i = 0; $i < count($selectedTaskTrees); $i++) {
        $selectedTaskTreesTableBlocked .=  '<tr>';
        $selectedTaskTreesTableBlocked .=  '<td>' . $selectedTaskTrees[$i]['TaskNumber'] . '</td>';
        $selectedTaskTreesTableBlocked .=  '<td><input id="' . $selectedTaskTrees[$i]['id'] . '" type="checkbox" class="checkitem_blocked" value="' . $selectedTaskTrees[$i]['id'] . '" style="margin-right: 12px;" /></td>';
        $selectedTaskTreesTableBlocked .=  '</tr>';
    }
    ?>


    <div class="row justify-content-center">
        <div class="form-row" style="font-size: 14px;">
            <hr>
            <table class="table table-sm table-hover" id="selectedTaskTreesTable">
                <thead>
                    <tr>
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

    <script>
        $(document).ready(function() {
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