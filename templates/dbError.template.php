<!-- 
    BŁĄD POŁĄCZENIA Z BAZĄ DANYCH 
    * ©Copyright 2019
    * Karol Osica
-->

<html>

<head>
    <title>TaskTree - Jira</title>
    <link rel="shortcut icon" href="./pictures/icons8-book-shelf-64.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
</head>

<body>
</body>
<div class="alert alert-danger kso-alert" role="alert">
    <b>Błąd!</b><br />
    <i>Brak połączenia z bazą danych!</i><br /><br />
    <i><?= $db_connect->connect_error ?></i>
</div>

</html>
<?php
exit;
