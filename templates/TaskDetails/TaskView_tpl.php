<!-- 
    SZKIELET SEKCJI Zarządzanie Zadaniami
    * ©Copyright 2019
    * Karol Osica
 -->
<div class="container" style="margin-top: 2%;">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="shadow-lg card text-center bg-primary text-light">
                <h2 style="text-align: center;">Zarządzanie zadaniami</h2>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <!-- Pierwszy wiersz  -->
        <div class="col-sm-5" id="treeListTASK"></div> <!-- Lista drzew  -->
        <div class="col-sm-7" id="taskListTASK"></div> <!-- Lista zadań  -->
    </div>
    <hr>
    <div class="row justify-content-center">
        <!-- Drugi wiersz  -->
        <div class="col-sm-5" id="taskDetailsTASK"></div> <!-- Zawartość wybranego drzewa  -->
        <div class="col-sm-7" id="taskFormTASK"></div> <!-- Zawartość wybranego drzewa  -->
    </div>
</div>
<div id="process"></div> <!-- kontener procesowy  -->

<!-- JavaScript - obsługa -->

<script>
    $(document).ready(function() {

        // pobieranie nowej listy drzew
        $("#treeListTASK").load("templates/TaskDetails/TreeList_tpl.php", function(responseTxt, statusTxt, xhr) {
            if (statusTxt == "error")
                alert("Błąd! Skontaktuj się z administratorem!");
        });

        // akcja po wybraniu drzewa
        $(document).on('click', ".btn-tree-TASK", function() {
            var treeID = $(this).attr("id");
            $("#taskDetailsTASK").html("");
            $("#taskFormTASK").html("");
            $("#taskListTASK").load("templates/TaskDetails/TaskList_tpl.php?treeID=" + treeID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });

        // akcja po wybarniu zadania
        $(document).on('click', ".btn-task-TASK", function() {
            var taskID = $(this).attr("id");
            $("#taskFormTASK").html("");
            $("#taskDetailsTASK").load("templates/TaskDetails/TaskDetails_tpl.php?taskID=" + taskID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });
    });
</script>