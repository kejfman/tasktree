<div class="container" style="margin-top: 2%;">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="shadow card text-center bg-primary text-light">
                <h2 style="text-align: center;">Zarządzanie słownikami</h2>
            </div>
        </div>
    </div>

    <hr>
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="shadow card">

                <div class="card-header bg-secondary text-center">

                    <font size="5" class="text-light">Dostępne słowniki</font>
                </div>

                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>A001</td>
                                <td>Faza wykonania</td>
                                <td>
                                    <button id="dictA001" type="button" class="btn btn-sm btn-outline-info" style="width: 100%;">🖋</button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>A002</td>
                                <td>Grupa wsparcia</td>
                                <td>
                                    <button id="dictA002" type="button" class="btn btn-sm btn-outline-info" style="width: 100%;">🖋</button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>A003</td>
                                <td>Środowisko</td>
                                <td>
                                    <button id="dictA003" type="button" class="btn btn-sm btn-outline-info" style="width: 100%;">🖋</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="selectedDict" class="col-sm-6">
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {

        $('#dictA001').click(function() {
            document.getElementById("dictA001").disabled = true;
            document.getElementById("dictA001").innerHTML = "📝";

            document.getElementById("dictA002").disabled = false;
            document.getElementById("dictA002").innerHTML = "🖋";

            document.getElementById("dictA003").disabled = false;
            document.getElementById("dictA003").innerHTML = "🖋";


            $("#selectedDict").load("templates/selectedDict_tpl.php?dict=A001", function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });

        });

        $('#dictA002').click(function() {
            document.getElementById("dictA002").disabled = true;
            document.getElementById("dictA002").innerHTML = "📝";

            document.getElementById("dictA001").disabled = false;
            document.getElementById("dictA001").innerHTML = "🖋";

            document.getElementById("dictA003").disabled = false;
            document.getElementById("dictA003").innerHTML = "🖋";

            $("#selectedDict").load("templates/selectedDict_tpl.php?dict=A002", function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });

        });

        $('#dictA003').click(function() {
            document.getElementById("dictA003").disabled = true;
            document.getElementById("dictA003").innerHTML = "📝";

            document.getElementById("dictA001").disabled = false;
            document.getElementById("dictA001").innerHTML = "🖋";

            document.getElementById("dictA002").disabled = false;
            document.getElementById("dictA002").innerHTML = "🖋";

            $("#selectedDict").load("templates/selectedDict_tpl.php?dict=A003", function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
        });
    });
</script>