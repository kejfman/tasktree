<?php

/**
 * Klasa umożliwiająca zarządzanie zadaniami w aplikacji Task Tree
 * ©Copyright 2019
 * Karol Osica
 */

class Task
{
    public $id = null;
    public $TaskNumber = null; // numer zadania
    public $TaskTree = null; // tablica z zadaniami które blokują to zadanie
    public $TaskOwner = null; // tablica z zadaniami które blokuje to zadanie 
    public $TaskType = null; // rodzaj zadania
    public $MyTask = null;
    public $CreateDateTime = null;
    public $Done = null;
    public $DoneDateTime = null;



    /**
     * Konstruktor, tworzy obiekt Zadanie
     * @var mysqli $connection - połączenie do bazy danych
     * @var string $taskID - identyfikator zadania
     */
    public function __construct(mysqli $connection, string $taskID)
    {
        $querySELECT_pt_tasks = "SELECT * FROM pt_tasks WHERE id = $taskID;";
        if ($resultSELECT_pt_tasks = $connection->query($querySELECT_pt_tasks)) {
            $rowSELECT_pt_task = $resultSELECT_pt_tasks->fetch_assoc();
            $this->id = $rowSELECT_pt_task['id'];
            $this->TaskNumber = $rowSELECT_pt_task['TaskNumber'];
            $this->TaskTree = $rowSELECT_pt_task['TaskTree'];
            $this->TaskOwner = $rowSELECT_pt_task['TaskOwner'];
            $this->TaskType = $rowSELECT_pt_task['TaskType'];
            $this->MyTask = $rowSELECT_pt_task['MyTask'];
            $this->CreateDateTime = $rowSELECT_pt_task['CreateDateTime'];
            $this->Done = $rowSELECT_pt_task['Done'];
            $this->DoneDateTime = $rowSELECT_pt_task['DoneDateTime'];
        } else {
            return "Błąd połączenia z bazą danych! Task::addNewTask";
        }
    }

    /**
     * Zmiana statusu zadania na ZAMKNIĘTE
     * @var mysqli $connection - połączenie do bazy danych
     * @var string $taskID - identyfikator zadania 
     */
    public static function setDoneStatus(mysqli $connection, string $taskID)
    {
        $now = date("Y-m-d H:i:s");
        $queryDone_pt_tasks = "UPDATE pt_tasks SET Done = '1', DoneDateTime = '$now' WHERE id = $taskID;";
        if (!$resultDone_pt_tasks = $connection->query($queryDone_pt_tasks)) {
            return "Błąd połączenia z bazą danych! Task::setDoneStatus";
        }
    }

    /**
     * Zmiana statusu zadania na OTWARTE
     * @var mysqli $connection - połączenie do bazy danych
     * @var string $taskID - identyfikator zadania 
     */
    public static function unsetDoneStatus(mysqli $connection, string $taskID)
    {
        $now = date("Y-m-d H:i:s");
        $queryDone_pt_tasks = "UPDATE pt_tasks SET Done = '0', DoneDateTime = '$now' WHERE id = $taskID;";
        if (!$resultDone_pt_tasks = $connection->query($queryDone_pt_tasks)) {
            return "Błąd połączenia z bazą danych! Task::setDoneStatus";
        }
    }




    /**
     * Dodawanie nowego zadania, funkcja ta automatycznie tworzy dodawanie zadanie oraz zadania powiązane (sprawdzając uprzenio czy nie zostały one utworzone wcześniej),
     * dodatkowo tworzone są połączenia pomiędzy zadaniami.
     * @var mysqli $connection - połączenie do bazy danych
     * @var array $taskDetails - tablica zawierająca szczegółowe informacje na tremat dodawanego zadania (oraz zadań powiązanych)
     */
    public static function addNewTask(mysqli $connection, array $taskDetails)
    {
        if (!isset($taskDetails['TaskNumber']) || $taskDetails['TaskNumber'] == '') {
            $infoLog['nok'][] = 'Nie podano numeru Zadania!';
            return $infoLog;
        }

        $TaskNumber = $taskDetails['TaskNumber'];
        $now = date("Y-m-d H:i:s");
        $infoLog = array();

        $querySelect_pt_tasks_check = "SELECT id FROM pt_tasks WHERE TaskNumber = '" . $taskDetails['TaskNumber'] . "';";
        if ($resultSelect_pt_tasks_check = $connection->query($querySelect_pt_tasks_check)) {
            if ($rowSelect_pt_tasks_check = $resultSelect_pt_tasks_check->fetch_assoc() <= 0) {
                $queryINSERT_pt_tasks = "INSERT INTO pt_tasks (TaskTree, TaskNumber, TaskOwner, TaskType, MyTask, CreateDateTime) 
                VALUES ('" . $taskDetails['TaskTree'] . "','" . $taskDetails['TaskNumber'] . "', '" . $taskDetails['TaskOwner'] . "', '" . $taskDetails['TaskType'] . "' , '" . $taskDetails['MyTask'] . "', '" . $now . "');";
                if (!$connection->query($queryINSERT_pt_tasks)) {
                    $infoLog['nok'][] = "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                } else {
                    $infoLog['ok'][] = "Zadanie " . $taskDetails['TaskNumber'] . " zostało utworzone!";
                }
            } else {
                $infoLog['nok'][] = "Zadanie " . $taskDetails['TaskNumber'] . " już istnieje!";
            }
        } else {
            $infoLog['nok'][] = "Błąd połczenia z bazą danych! Task::addNewTask" . $connection->error;
        }

        foreach ($taskDetails as $key => $value) {
            if ($key == 'TaskBlocks' || $key == 'TaskBlockedBy') {
                for ($i = 0; $i < count($value); $i++) {
                    if (!isset($value[$i]['TaskNumber']) || $value[$i]['TaskNumber'] == '') {
                        continue;
                    }
                    $querySelect_pt_tasks_check = "SELECT id FROM pt_tasks WHERE TaskNumber = '" . $value[$i]['TaskNumber'] . "';";
                    if ($resultSelect_pt_tasks_check = $connection->query($querySelect_pt_tasks_check)) {
                        if ($rowSelect_pt_tasks_check = $resultSelect_pt_tasks_check->fetch_assoc() <= 0) {
                            $queryINSERT_pt_tasks = "INSERT INTO pt_tasks (TaskTree, TaskNumber, TaskOwner, TaskType, CreateDateTime) 
                            VALUES ('" . $value[$i]['TaskTree'] . "','" . $value[$i]['TaskNumber'] . "', '" . $value[$i]['TaskOwner'] . "', '" . $value[$i]['TaskType'] . "', '" . $now . "');";
                            if (!$connection->query($queryINSERT_pt_tasks)) {
                                $infoLog['nok'][] = "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                            } else {
                                $infoLog['ok'][] = "Zadanie " . $value[$i]['TaskNumber'] . " zostało utworzone!";
                            }
                        } else {
                            $infoLog['nok'][] = "Zadanie " . $value[$i]['TaskNumber'] . " już istnieje!";
                        }
                    } else {
                        $infoLog['nok'][] = "Błąd połczenia z bazą danych! Task::addNewTask" . $connection->error;
                    }
                }
            }
        }

        foreach ($taskDetails as $key => $value) {
            if ($key == 'TaskBlocks') {
                for ($i = 0; $i < count($value); $i++) {
                    if (!isset($value[$i]['TaskNumber']) || $value[$i]['TaskNumber'] == '') {
                        continue;
                    }
                    $querySELECT_pt_tasks_block_check = "SELECT id FROM pt_tasks_block WHERE TaskBlockTaskNumber = '" . $value[$i]['TaskNumber'] . "' AND TaskBlockByNumber = '$TaskNumber';";
                    if ($resultSELECT_pt_tasks_block_check = $connection->query($querySELECT_pt_tasks_block_check)) {
                        if ($resultSELECT_pt_tasks_block_check->fetch_assoc() <= 0) {
                            $queryINSERT_pt_tasks_block_s = "INSERT INTO pt_tasks_block (TaskTree, TaskBlockTaskNumber, TaskBlockByNumber)
                                VALUES ('" . $taskDetails['TaskTree'] . "','" . $value[$i]['TaskNumber'] . "', '$TaskNumber');";
                            echo '<br />';
                            if (!$connection->query($queryINSERT_pt_tasks_block_s)) {
                                $infoLog['nok'][] = "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                            } else {
                                $infoLog['ok'][] = "Utworzono połączenie: zadanie " . $TaskNumber . " blokuje zdanie " . $value[$i]['TaskNumber'] . " !";
                            }
                        } else {
                            $infoLog['nok'][] = "Połączenie: zadanie " . $TaskNumber . " blokuje zdanie " . $value[$i]['TaskNumber'] . " - już istnieje!";
                        }
                    } else {
                        $infoLog['nok'][] = "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                    }
                }
            } elseif ($key == 'TaskBlockedBy') {
                for ($i = 0; $i < count($value); $i++) {
                    if (!isset($value[$i]['TaskNumber']) || $value[$i]['TaskNumber'] == '') {
                        continue;
                    }
                    $querySELECT_pt_tasks_block_check = "SELECT id FROM pt_tasks_block WHERE TaskBlockTaskNumber = '$TaskNumber' AND TaskBlockByNumber = '" . $value[$i]['TaskNumber'] . "';";
                    if ($resultSELECT_pt_tasks_block_check = $connection->query($querySELECT_pt_tasks_block_check)) {
                        if ($resultSELECT_pt_tasks_block_check->fetch_assoc() <= 0) {
                            $queryINSERT_pt_tasks_block_by = "INSERT INTO pt_tasks_block (TaskTree, TaskBlockTaskNumber, TaskBlockByNumber)
                                            VALUES ('" . $taskDetails['TaskTree'] . "', '$TaskNumber', '" . $value[$i]['TaskNumber'] . "');";

                            if (!$connection->query($queryINSERT_pt_tasks_block_by)) {
                                $infoLog['nok'][] = "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                            } else {
                                $infoLog['ok'][] = "Utworzono połączenie: zadanie " . $value[$i]['TaskNumber'] . " jest blokowane przez zdanie " . $TaskNumber . " !";
                            }
                        } else {
                            $infoLog['nok'][] = "Połączenie: zadanie " . $value[$i]['TaskNumber'] . " jest blokowane przez zdanie " . $TaskNumber . " - już istnieje!";
                        }
                    } else {
                        $infoLog['nok'][] = "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                    }
                }
            }
        }

        return $infoLog;
    }

    /**
     * Pobieranie listy wszystkich zadań
     * @var mysqli $connection - połączenie do bazy danych
     */
    public static function getAllTasksList(mysqli $connection)
    {
        $querySELECT_pt_tasks = "SELECT * FROM pt_tasks;";
        if (!$resultSELECT_pt_tasks = $connection->query($querySELECT_pt_tasks)) {
            return $infoLog['nok'][] = "Błąd połączenia z bazą danych! Task::getAllTasksList" . $connection->error;
        } else {
            while ($rowSELECT_pt_tasks = $resultSELECT_pt_tasks->fetch_assoc()) {
                $tasksList[] = $rowSELECT_pt_tasks;
            }
        }
        return $tasksList;
    }

    /**
     * Pobieranie numeru zadania po identyfikatorze
     * @var mysqli $connection - połączenie do bazy danych
     * @var string $treeId - identyfikator zadania
     */
    public static function getTaskNumberById(mysqli $connection, string $treeId)
    {
        $querySELECT_pt_tasks = "SELECT TaskNumber FROM pt_tasks WHERE id = '$treeId';";
        if (!$resultSELECT_pt_tasks = $connection->query($querySELECT_pt_tasks)) {
            $infoLog['nok'][] = "Błąd połączenia z bazą danych! Task::getTaskNumberById" . $connection->error . "<br /><b>Skontaktuj się z administratorem!</b>";
        } else {
            while ($rowSELECT_pt_tasks = $resultSELECT_pt_tasks->fetch_assoc()) {
                $tasksName = $rowSELECT_pt_tasks['TaskNumber'];
            }
            if (!empty($tasksName)) {
                return $tasksName;
            }
        }
        return $infoLog;
    }

    /**
     * Tworzenie relacji pomiędzy zadaniami
     * @var mysqli $connection - połączenie do bazy danych
     * @var string $Task - identyfikator blokowanego zadania
     * @var string $TaskBlockedBy - identyfikator blokującego zadania
     */
    public static function setRelation(mysqli $connection, string $Task, string $TaskBlockedBy)
    {
        if (isset($Task) && $Task != '' && isset($TaskBlockedBy) && $TaskBlockedBy != '') {
            $queryINSERT_pt_tasks = "INSERT INTO pt_tasks_block (TaskBlockTaskNumber, TaskBlockByNumber) VALUES ('$Task', '$TaskBlockedBy');";
            if (!$connection->query($queryINSERT_pt_tasks)) {
                return "Błąd połączenia z bazą danych! Task::getAllTasksList" . $connection->error . "<br /><b>Skontaktuj się z administratorem!</b>";
            } else {
                $infoLog['ok'][] = "Utworzono połączenie: zadanie " . $Task . " jest blokowane przez zdanie " . $TaskBlockedBy . " !";
            }
        } else {
            $infoLog['nok'][] = "Nie podano numeru zadania: Blokowane: (" . $Task . ") Blokujące (" . $TaskBlockedBy . ")!";
        }
        return $infoLog;
    }


    /**
     * Pobieranie listy zadań blokowanych przez podane zadanie / blokujących podane zadanie
     * @var mysqli $connection - połączenie do bazy danych
     * @var string $Task - identyfikator zadania odniesienia
     * @var string $param - parametr:
     *                      - by - przez
     *                      - s - blokuje
     */
    public static function getBlocksTasks(mysqli $connection, string $Task, string $param = null, string $treeId)
    {
        if ($param == null || $param == "by") {
            $querySELECT_pt_tasks_block = "SELECT * FROM pt_tasks_block WHERE TaskBlockTaskNumber = '$Task' AND TaskTree = '$treeId';";
        } elseif ($param == "s") {
            $querySELECT_pt_tasks_block = "SELECT * FROM pt_tasks_block WHERE TaskBlockByNumber = '$Task' AND TaskTree = '$treeId';";
        } else {
            return "Błędny parametr!";
        }

        if (!$resultSELECT_pt_tasks_block = $connection->query($querySELECT_pt_tasks_block)) {
            return "Błąd połączenia z bazą danych! Task::getBlocksTasks" . $connection->error;
        } else {
            $tasks = '';
            while ($rowSELECT_pt_tasks_block = $resultSELECT_pt_tasks_block->fetch_assoc()) {


                if ($param == null || $param == "by") {
                    $tasks .= "'" . $rowSELECT_pt_tasks_block['TaskBlockByNumber'] . "', ";
                } elseif ($param == "s") {
                    $tasks .= "'" . $rowSELECT_pt_tasks_block['TaskBlockTaskNumber'] . "', ";
                } else {
                    return "Błędny parametr!";
                }
            }
            $tasks .= "'000'";

            if (isset($tasks) && $tasks != '') {
                $querySelect = "";
                $querySelect = "SELECT * FROM pt_tasks WHERE TaskNumber IN ($tasks) AND TaskTree = '$treeId'";
                if (!$resultSELECT = $connection->query($querySelect)) {
                    return "Błąd połączenia z bazą danych! Task::getBlocksTasks" . $connection->error;
                } else {

                    while ($rowSELECT = $resultSELECT->fetch_assoc()) {
                        $blocksTasks[] = $rowSELECT;
                    }
                }
            }
        }
        if (isset($blocksTasks)) {
            return $blocksTasks;
        }
    }


    /**
     * Usuwanie zadania
     * @var mysqli $connection - połączenie z bazą danych
     * @var string $treeId - identyfikator zadania
     */
    public static function deleteTask(mysqli $connection, string $treeId)
    {
        $queryDELETE = "DELETE FROM pt_tasks WHERE id = '$treeId';";
        if (!$connection->query($queryDELETE)) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Uaktualnienie danych wybranego zadania
     * @var mysqli $connection - połączenie z bazą danych
     * @var array $taskDetails - tablica z nowymi danymi zadania 
     */
    public static function updateTask(mysqli $connection, array $taskDetails)
    {
        $queryUPDATE = "UPDATE pt_tasks SET TaskTree = '" . $taskDetails['taskTree'] . "', TaskOwner = '" . $taskDetails['taskGroup'] . "', TaskType = '" . $taskDetails['taskType'] . "', MyTask = " . $taskDetails['taskMy'] . " WHERE id = " . $taskDetails['taskID'] . ";";

        if (!$connection->query($queryUPDATE)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Pobieranie listy połączeń pomiędzy zadaniami w drzewie
     * @var mysqli $connection - połączenie z bazą danych
     * @var string $treeId - identyfikator drzewa
     */
    public static function getAllTaskConnectionsInTree(mysqli $connection, string $treeId)
    {
        $querySELECT = "SELECT * FROM pt_tasks_block WHERE TaskTree = '$treeId';";

        if (!$resultSELECT = $connection->query($querySELECT)) {
            return false;
        } else {
            while ($rowSELECT = $resultSELECT->fetch_assoc()) {
                $taskConnections[] = $rowSELECT;
            }
            if (isset($taskConnections)) {
                return $taskConnections;
            } else {
                return false;
            }
        }
    }

    /**
     * Pobieranie listy zadań w drzewie
     * @var mysqli $connection - połączenie z bazą danych
     * @var string $treeId - identyfikator drzewa
     */
    public static function getAllTaskInTree(mysqli $connection, string $treeId)
    {
        $querySELECT = "SELECT * FROM pt_tasks WHERE TaskTree = '$treeId';";

        if (!$resultSELECT = $connection->query($querySELECT)) {
            return false;
        } else {
            while ($rowSELECT = $resultSELECT->fetch_assoc()) {
                $taskInTree[] = $rowSELECT;
            }
            if (isset($taskInTree)) {
                return $taskInTree;
            } else {
                return false;
            }
        }
    }

    /**
     * Kopiowanie zadań drzewa wraz z połączeniami 
     * @var mysqli $connection - połączenie z bazą danych
     * @var string $treeId - identyfikator drzewa
     * @var string $newTreeName - nazwa nowego drzewa 
     */
    public static function cloneTreeTasks(mysqli $connection, string $treeId, string $newTreeName)
    {
        // pobieramy ID nowo utworzonej kopi:
        $querySELECT = "SELECT id FROM pt_trees WHERE TreeName = '$newTreeName';";
        if (!$resultSELECT = $connection->query($querySELECT)) {
            return false;
        } else {
            $rowSELECT = $resultSELECT->fetch_assoc();
            $copyTreeId = $rowSELECT['id'];
        }

        if (!isset($copyTreeId) || $copyTreeId == '') {
            $log['nok'][] = "Błąd, nie utworzono kopi drzewa.";
        } else {
            $log['ok'][] = "Poprawnie pobrano identyfikator kopiowanego drzewa!";
            $now = date("Y-m-d H:i:s");
            // Kopiowanie zadań
            $tasksInTree = self::getAllTaskInTree($connection, $treeId);
            if (!isset($tasksInTree) || $tasksInTree == false) {
                $log['nok'][] = "Skopiowane drzewo nie posiadało zadań!";
            } else {
                foreach ($tasksInTree as  $value) {
                    $queryINSERT = "INSERT INTO pt_tasks (TaskTree, TaskNumber, TaskOwner, TaskType, MyTask, CreateDateTime)
                                    VALUES ('" . $copyTreeId . "','" . $value['TaskNumber'] . "','" . $value['TaskOwner'] . "','" . $value['TaskType'] . "','" . $value['MyTask'] . "', '$now');";
                    $connection->query($queryINSERT);
                }

                $log['ok'][] = "Poprawnie skopiowano zadania do nowego drzewa!";

                // Kopiowanie listy powiązanych zadań kopiowanego drzewa 
                $taskConnections = self::getAllTaskConnectionsInTree($connection, $treeId);
                if (!isset($tasksInTree) || $tasksInTree == false) {
                    $log['nok'][] = "Zadania w kopiowanym drzewie nie posiadały relacji!";
                } else {
                    foreach ($taskConnections as  $value) {
                        $queryINSERT = "INSERT INTO pt_tasks_block (TaskTree, TaskBlockTaskNumber, TaskBlockByNumber)
                                    VALUES ('" . $copyTreeId . "','" . $value['TaskBlockTaskNumber'] . "','" . $value['TaskBlockByNumber'] . "');";
                        $connection->query($queryINSERT);
                    }
                    $log['ok'][] = "Poprawnie utworzono powiązania pomiędzy zadaniami w nowym drzewie!";
                }
            }
        }

        return $log;
    }
}
