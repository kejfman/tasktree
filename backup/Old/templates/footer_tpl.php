<script>
    $(document).ready(function() {
        x = document.getElementById("ManageTrees");
        y = document.getElementById("addNewTask");
        z = document.getElementById("ManageDictionaries");
        t = document.getElementById("viewTaskTree");
        u = document.getElementById("ManageTasks");



        $('#ManageTrees').click(function() {

            y.style.color = "black";
            y.style.background = "#ffffff";
            y.disabled = false;

            z.style.color = "black";
            z.style.background = "#ffffff";
            z.disabled = false;

            t.style.color = "black";
            t.style.background = "#ffffff";
            t.disabled = false;

            u.style.color = "black";
            u.style.background = "#ffffff";
            u.disabled = false;


            $("#main").load("templates/ManageTrees_tpl.php", function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Błąd! Skontaktuj się z administratorem!");
            });
            x.style.color = "#ba4a00";
            x.style.background = "#d5dbdb";
            x.disabled = true;

        });

        $('#addNewTask').click(function() {
            x.style.color = "black";
            x.style.background = "#ffffff";
            x.disabled = false;

            z.style.color = "black";
            z.style.background = "#ffffff";
            z.disabled = false;

            t.style.color = "black";
            t.style.background = "#ffffff";
            t.disabled = false;

            u.style.color = "black";
            u.style.background = "#ffffff";
            u.disabled = false;

            $("#main").load("templates/addNewTask_tpl.php", function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "success")
                    if (statusTxt == "error")
                        alert("Błąd! Skontaktuj się z administratorem!");
            });
            y.style.color = "#ba4a00";
            y.style.background = "#d5dbdb";
            y.disabled = true;
        });


        $('#ManageDictionaries').click(function() {
            x.style.color = "black";
            x.style.background = "#ffffff";
            x.disabled = false;

            y.style.color = "black";
            y.style.background = "#ffffff";
            y.disabled = false;

            t.style.color = "black";
            t.style.background = "#ffffff";
            t.disabled = false;

            u.style.color = "black";
            u.style.background = "#ffffff";
            u.disabled = false;

            $("#main").load("templates/manageDictionaries_tpl.php", function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "success")
                    if (statusTxt == "error")
                        alert("Błąd! Skontaktuj się z administratorem!");
            });

            z.style.color = "#ba4a00";
            z.style.background = "#d5dbdb";
            z.disabled = true;
        });



        $('#ManageTasks').click(function() {

            x.style.color = "black";
            x.style.background = "#ffffff";
            x.disabled = false;

            y.style.color = "black";
            y.style.background = "#ffffff";
            y.disabled = false;

            z.style.color = "black";
            z.style.background = "#ffffff";
            z.disabled = false;

            t.style.color = "black";
            t.style.background = "#ffffff";
            t.disabled = false;

            $("#main").load("templates/ManageTasks/manageTasks_tpl.php", function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "success")
                    if (statusTxt == "error")
                        alert("Błąd! Skontaktuj się z administratorem!");
            });

            u.style.color = "#ba4a00";
            u.style.background = "#d5dbdb";
            u.disabled = true;
        });




        $('#viewTaskTree').click(function() {

            x.style.color = "black";
            x.style.background = "#ffffff";
            x.disabled = false;

            y.style.color = "black";
            y.style.background = "#ffffff";
            y.disabled = false;

            z.style.color = "black";
            z.style.background = "#ffffff";
            z.disabled = false;

            u.style.color = "black";
            u.style.background = "#ffffff";
            u.disabled = false;

            $("#main").load("templates/taskTreeView_tpl.php", function(responseTxt, statusTxt, xhr) {
                if (statusTxt == "success")
                    if (statusTxt == "error")
                        alert("Błąd! Skontaktuj się z administratorem!");
            });

            t.style.color = "#ba4a00";
            t.style.background = "#d5dbdb";
            t.disabled = true;
        });

    });
</script>

</body>

</html>