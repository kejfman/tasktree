<!DOCTYPE html>
<html>

<head>
    <title>G. Makowski Task Tree</title>
    <link rel="shortcut icon" href="./pictures/network.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <style>
        .sidenav {
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 2%;
            left: 10px;
            overflow-x: hidden;
            /* padding: 8px 0; */
        }

        .main {
            margin-left: 260px;
            margin-top: 2%;
            /* padding: 0px 10px; */
        }
    </style>

    <!-- <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery.min.js"></script> -->

</head>

<body>
    <div class="sidenav">
        <div class="list-group">
            <button type="button" class="list-group-item list-group-item-action active">
                Menu
            </button>
            <button id="ManageTrees" type="button" class="list-group-item list-group-item-action">Drzewa zadań</button>
            <button id="addNewTask" type="button" class="list-group-item list-group-item-action">Nowe zadanie</button>
            <button id="ManageDictionaries" type="button" class="list-group-item list-group-item-action">Zarządzanie słownikami</button>
            <button id="ManageTasks" type="button" class="list-group-item list-group-item-action">Zarządzanie zadaniami</button>
            <button id="viewTaskTree" type="button" class="list-group-item list-group-item-action">Przeglądaj drzewa</button>
        </div>
    </div>
    <div id="main" class="main">
    </div>