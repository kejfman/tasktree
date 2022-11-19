<!-- 
    SZKIELET - Przeglądania drzew
 -->
<div class="container" style="margin-top: 2%;">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="shadow-lg card text-center bg-primary text-light">
                <h2 style="text-align: center;">Drzewa</h2>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <!-- Pierwszy wiersz  -->
        <div class="col-sm-6" id="treeList"></div> <!-- Lista drzew  -->
        <div class="col-sm-6" id="treeDetails"></div> <!-- Szczegóły wybranego drzewa  -->
    </div>
    <hr>
    <div class="row justify-content-center">
        <!-- Drugi wiersz  -->
        <div class="col-sm-7" id="treeContent"></div> <!-- Zawartość wybranego drzewa  -->
        <div class="col-sm-5" id="taskDet"></div> <!-- Detale wybranego zadania  -->
    </div>
</div>

<div id="process"></div> <!-- kontener procesowy  -->

<!-- JavaScript - obsługa -->

<script>
    $(document).ready(function() {
        // Pobieranie listy drzew
        $("#treeList").load("templates/TreeDetails/TreeList_tpl.php", function(responseTxt, statusTxt, xhr) {
            if (statusTxt == "error")
                alert("Błąd! Skontaktuj się z administratorem!");
        });

        // Wybrane danych konkretnego drzewa
        $(document).on('click', ".btn-tree", function() {
            var treeID = $(this).attr("id");
            $("#treeDetails").load("templates/TreeDetails/selectedTreeDetails_tpl.php?treeID=" + treeID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
            $("#treeContent").load("templates/TreeDetails/treeContent_tpl.php?treeID=" + treeID, function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
            document.getElementById("taskDet").innerHTML = "";
        });
    });
</script>