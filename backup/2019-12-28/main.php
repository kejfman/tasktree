<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">






<div id="odp">
</div>

<div class="container" style="margin-top: 2%;">

    <div class="row justify-content-center">
        <div class="col-sm-12">
    <h2 style="text-align: center;">Nowe zadanie</h2>
        </div>
    </div>


    <form method="POST" name="addNewTask" id="addNewTask">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="TaskTree">Drzewo zadań</label>
                <select id="TaskTree" name="TaskTree" class="form-control">
                    <option selected>aaa11</option>
                    <option>bbb22</option>
                    <option>ccc33</option>
                </select>
            </div>
        </div>

        <div class="form-row">

            <div class="form-group col-md-3">
                <label for="TaskNumber">Numer zadania</label>
                <input type="text" class="form-control" id="TaskNumber" name="TaskNumber">
            </div>

            <div class="form-group col-md-3">
                <label for="TaskOwner">Właściciel zadania</label>
                <input type="text" class="form-control" id="TaskOwner" name="TaskOwner">
            </div>

            <div class="form-group col-md-3">
                <label for="TaskType">Typ zadania</label>
                <input type="text" class="form-control" id="TaskType" name="TaskType">
            </div>

            <div class="form-group col-md-3">
                <label for="TaskGroup">Grupa</label>
                <input type="text" class="form-control" id="TaskGroup" name="TaskGroup">
            </div>


        </div>


        <br />
        <div class="form-row" id="BlocksRowDiv">

            <table class="table" id="BlocksRow">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center;">Zadanie blokuje:</th>

                    </tr>
                    <tr>
                        <th>Numer zadania</th>
                        <th>Właściciel zadania</th>
                        <th>Typ zadania</th>
                        <th>Grupa</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="TaskNumberBlocks" name="TaskNumberBlocks[]">
                        </td>

                        <td>
                            <input type="text" class="form-control" id="TaskOwnerBlocks" name="TaskOwnerBlocks[]">
                        </td>

                        <td>
                            <input type="text" class="form-control" id="TaskTypeBlocks" name="TaskTypeBlocks[]">
                        </td>

                        <td>
                            <input type="text" class="form-control" id="TaskGroupBlocks" name="TaskGroupBlocks[]">
                        </td>

                        <td>
                            <button id="addBlocksRow" type="button" class="btn btn-outline-success">➕</button>
                        </td>


                    </tr>
                </tbody>


            </table>

        </div>







        <br />
        <div class="form-row" id="BlocksRowDiv">

            <table class="table" id="BlockedRow">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center;">Zadanie jest blokowane przez:</th>

                    </tr>
                    <tr>
                        <th>Numer zadania</th>
                        <th>Właściciel zadania</th>
                        <th>Typ zadania</th>
                        <th>Grupa</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="TaskNumberBlocked" name="TaskNumberBlocked[]">
                        </td>

                        <td>
                            <input type="text" class="form-control" id="TaskOwnerBlocked" name="TaskOwnerBlocked[]">
                        </td>

                        <td>
                            <input type="text" class="form-control" id="TaskTypeBlocked" name="TaskTypeBlocked[]">
                        </td>

                        <td>
                            <input type="text" class="form-control" id="TaskGroupBlocked" name="TaskGroupBlocked[]">
                        </td>

                        <td>
                            <button id="addBlockedRow" type="button" class="btn btn-outline-success">➕</button>
                        </td>


                    </tr>
                </tbody>


            </table>

        </div>

        <!--
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-sm-11">
                    <h5>Zadanie jest blokowane przez:</h5>
                </div>
                <div class="col-sm-1">
                    <button id="addBlockedRow" type="button" class="btn btn-outline-success">➕</button>
                </div>
            </div>
        </div>
        <hr>

        <div class="form-row">

            <div class="form-group col-md-3">
                <label for="TaskNumberBlocke[]">Numer zadania</label>
                <input type="text" class="form-control" id="TaskNumberBlocked" name="TaskNumberBlocked[]">
            </div>

            <div class="form-group col-md-3">
                <label for="TaskOwnerBlocked">Właściciel zadania</label>
                <input type="text" class="form-control" id="TaskOwnerBlocked" name="TaskOwnerBlocked[]">
            </div>

            <div class="form-group col-md-3">
                <label for="TaskTypeBlocked">Typ zadania</label>
                <input type="text" class="form-control" id="TaskTypeBlocked" name="TaskTypeBlocked[]">
            </div>

            <div class="form-group col-md-3">
                <label for="TaskGroupBlocked">Grupa</label>
                <input type="text" class="form-control" id="TaskGroupBlocked" name="TaskGroupBlocked[]">
            </div>


        </div>


-->

        <hr>

        <div class="form-row">
            <div class="form-group col-md-12">
                <input type="button" class="btn btn-secondary btn-lg" style="width: 100%;" id="start" value="Zapisz">
            </div>
        </div>
    </form>

</div>



































<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>





















<script>
    $(document).ready(function() {
        // $("#start").click(function() {
        //     document.getElementById("start").disabled = true;
        //     document.getElementById("start").value = "Przetwarzanie...";

        //     $("#odp").load("scripts/createNewTask.php", function(responseTxt, statusTxt, xhr) {
        //         if (statusTxt == "success")
        //             document.getElementById("start").disabled = false;
        //         document.getElementById("start").value = "Zapisz";
        //         if (statusTxt == "error")
        //             alert("Error: " + xhr.status + ": " + xhr.statusText);
        //         document.getElementById("start").disabled = false;
        //         document.getElementById("start").value = "Zapisz";
        //     });


        // });
        // 
        //     <p>*</p>
        // </td>

        var i = 1;
        $('#addBlocksRow').click(function() {
            $('#BlocksRow').append('<tr id="BlocksRow' + i + '"><td><input type="text" class="form-control" id="TaskNumberBlocks' + i + '" name="TaskNumberBlocks[]"></td><td><input type="text" class="form-control" id="TaskOwnerBlocks' + i + '" name="TaskOwnerBlocks[]"></td><td><input type="text" class="form-control" id="TaskTypeBlocks' + i + '" name="TaskTypeBlocks[]"></td><td><input type="text" class="form-control" id="TaskGroupBlocks' + i + '" name="TaskGroupBlocks[]"></td><td><button id="' + i + '" type="button" class="btn btn-outline-danger btn_remove" style="width: 100%;">➖</button></td></tr>');
            i++;
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#BlocksRow' + button_id + '').remove();
        });





        var j = 1;
        $('#addBlockedRow').click(function() {
            j++;
            $('#BlockedRow').append('<tr id="BlockedRow' + j + '"><td><input type="text" class="form-control" id="TaskNumberBlocked' + j + '" name="TaskNumberBlocked[]"></td><td><input type="text" class="form-control" id="TaskOwnerBlocked' + j + '" name="TaskOwnerBlocked[]"></td><td><input type="text" class="form-control" id="TaskTypeBlocked' + j + '" name="TaskTypeBlocked[]"></td><td><input type="text" class="form-control" id="TaskGroupBlocked' + j + '" name="TaskGroupBlocked[]"></td><td><button id="' + j + '" type="button" class="btn btn-outline-danger btn_remove_blocked" style="width: 100%;">➖</button></td></tr>');
        });
        $(document).on('click', '.btn_remove_blocked', function() {
            var button_id = $(this).attr("id");
            $('#BlockedRow' + button_id + '').remove();
        });


        // /succes_template.php
        $('#start').click(function() {

            document.getElementById("start").disabled = true;
            document.getElementById("start").value = "Przetwarzanie...";


            $.ajax({
                url: "createNewTask.php",
                method: "POST",
                data: $('#addNewTask').serialize(),
                success: function(data) {



                    $("#odp").load("succes_template.php", function(responseTxt, statusTxt, xhr) {
                        if (statusTxt == "success")
                            document.getElementById("start").disabled = false;
                        document.getElementById("start").value = "Zapisz";
                        $('#addNewTask')[0].reset();
                        if (statusTxt == "error")
                            alert("Błąd! Skontaktuj się z administratorem!");
                        document.getElementById("start").disabled = false;
                        document.getElementById("start").value = "Zapisz";
                    });







                }


            });
        });


    });
</script>



<?php






// if(isset($_POST['TaskNumberBlocks'])) {


//     $taskDetails = [
//         'TaskTree' => $_POST['TaskTree'],
//         'TaskNumber' => $_POST['TaskNumber'],
//         'TaskOwner' => $_POST['TaskOwner'],
//         'TaskType' => $_POST['TaskType'],
//         'TaskGroup' => $_POST['TaskGroup']
//     ];


//     for($i = 0; $i < count($_POST['TaskNumberBlocks']); $i++) {
//         $taskDetails['TaskBlocks'][$i]['TaskTree'] = $_POST['TaskTree'];
//         $taskDetails['TaskBlocks'][$i]['TaskNumber'] = $_POST['TaskNumberBlocks'][$i];
//     }

//     for($i = 0; $i < count($_POST['TaskOwnerBlocks']); $i++) {
//         $taskDetails['TaskBlocks'][$i]['TaskOwner'] = $_POST['TaskOwnerBlocks'][$i];
//     }

//     for($i = 0; $i < count($_POST['TaskTypeBlocks']); $i++) {
//         $taskDetails['TaskBlocks'][$i]['TaskType'] = $_POST['TaskTypeBlocks'][$i];
//     }

//     for($i = 0; $i < count($_POST['TaskGroupBlocks']); $i++) {
//         $taskDetails['TaskBlocks'][$i]['TaskGroup'] = $_POST['TaskGroupBlocks'][$i];
//     }


//     for($i = 0; $i < count($_POST['TaskNumberBlocked']); $i++) {
//         $taskDetails['TaskBlockedBy'][$i]['TaskTree'] = $_POST['TaskTree'];
//         $taskDetails['TaskBlockedBy'][$i]['TaskNumber'] = $_POST['TaskNumberBlocked'][$i];
//     }

//     for($i = 0; $i < count($_POST['TaskOwnerBlocked']); $i++) {
//         $taskDetails['TaskBlockedBy'][$i]['TaskOwner'] = $_POST['TaskOwnerBlocked'][$i];
//     }

//     for($i = 0; $i < count($_POST['TaskTypeBlocked']); $i++) {
//         $taskDetails['TaskBlockedBy'][$i]['TaskType'] = $_POST['TaskTypeBlocked'][$i];
//     }

//     for($i = 0; $i < count($_POST['TaskGroupBlocked']); $i++) {
//         $taskDetails['TaskBlockedBy'][$i]['TaskGroup'] = $_POST['TaskGroupBlocked'][$i];
//     }







//     echo '<pre>';
//     print_r($taskDetails);
//     echo '<pre>';




// }









// echo '<pre>';

// print_r($newTaskLog);
// echo '</pre>';

?>

<!--

<html>

<head>
    <title>Dynamically Add or Remove input fields in PHP with JQuery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <br />
        <br />
        <h2 align="center">Dynamically Add or Remove input fields in PHP with JQuery</h2>
        <div class="form-group">
            <form name="add_name" id="add_name">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field">
                        <tr>
                            <td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>
                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                        </tr>
                    </table>
                    <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
        $('#submit').click(function() {
            $.ajax({
                url: "name.php",
                method: "POST",
                data: $('#add_name').serialize(),
                success: function(data) {
                    alert(data);
                    $('#add_name')[0].reset();
                }
            });
        });
    });
</script>