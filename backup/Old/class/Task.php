<?php

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

    public static function setDoneStatus(mysqli $connection, string $taskID)
    {
        $now = date("Y-m-d H:i:s");
        $queryDone_pt_tasks = "UPDATE pt_tasks SET Done = '1', DoneDateTime = '$now' WHERE id = $taskID;";
        if (!$resultDone_pt_tasks = $connection->query($queryDone_pt_tasks)) {
            return "Błąd połączenia z bazą danych! Task::setDoneStatus";
        }
    }



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
                    return "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                } else {
                    $infoLog['ok'][] = "Zadanie " . $taskDetails['TaskNumber'] . " zostało utworzone!";
                }
            } else {
                $infoLog['nok'][] = "Zadanie " . $taskDetails['TaskNumber'] . " już istnieje!";
            }
        } else {
            return "Błąd połczenia z bazą danych! Task::addNewTask" . $connection->error;
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
                                return "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                            } else {
                                $infoLog['ok'][] = "Zadanie " . $value[$i]['TaskNumber'] . " zostało utworzone!";
                            }
                        } else {
                            $infoLog['nok'][] = "Zadanie " . $value[$i]['TaskNumber'] . " już istnieje!";
                        }
                    } else {
                        return "Błąd połczenia z bazą danych! Task::addNewTask" . $connection->error;
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
                            $queryINSERT_pt_tasks_block_s = "INSERT INTO pt_tasks_block (TaskBlockTaskNumber, TaskBlockByNumber)
                                VALUES ('" . $value[$i]['TaskNumber'] . "', '$TaskNumber');";
                            echo '<br />';
                            if (!$connection->query($queryINSERT_pt_tasks_block_s)) {
                                return "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                            } else {
                                $infoLog['ok'][] = "Utworzono połączenie: zadanie " . $TaskNumber . " blokuje zdanie " . $value[$i]['TaskNumber'] . " !";
                            }
                        } else {
                            $infoLog['nok'][] = "Połączenie: zadanie " . $TaskNumber . " blokuje zdanie " . $value[$i]['TaskNumber'] . " - już istnieje!";
                        }
                    } else {
                        return "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
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
                            $queryINSERT_pt_tasks_block_by = "INSERT INTO pt_tasks_block (TaskBlockTaskNumber, TaskBlockByNumber)
                                            VALUES ('$TaskNumber', '" . $value[$i]['TaskNumber'] . "');";

                            if (!$connection->query($queryINSERT_pt_tasks_block_by)) {
                                return "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                            } else {
                                $infoLog['ok'][] = "Utworzono połączenie: zadanie " . $value[$i]['TaskNumber'] . " jest blokowane przez zdanie " . $TaskNumber . " !";
                            }
                        } else {
                            $infoLog['nok'][] = "Połączenie: zadanie " . $value[$i]['TaskNumber'] . " jest blokowane przez zdanie " . $TaskNumber . " - już istnieje!";
                        }
                    } else {
                        return "Błąd połączenia z bazą danych! Task::addNewTask" . $connection->error;
                    }
                }
            }
        }

        return $infoLog;
    }


    public static function getAllTasksList(mysqli $connection)
    {
        $querySELECT_pt_tasks = "SELECT * FROM pt_tasks;";
        if (!$resultSELECT_pt_tasks = $connection->query($querySELECT_pt_tasks)) {
            return "Błąd połączenia z bazą danych! Task::getAllTasksList" . $connection->error;
        } else {
            while ($rowSELECT_pt_tasks = $resultSELECT_pt_tasks->fetch_assoc()) {
                $tasksList[] = $rowSELECT_pt_tasks;
            }
        }
        return $tasksList;
    }


    public static function getTasksList(mysqli $connection, string $treeID, int $myTask = null)
    {
        if ($myTask == null) {
            $querySELECT_pt_tasks = "SELECT * FROM pt_tasks WHERE TaskTree = '$treeID';";
        } else {
            $querySELECT_pt_tasks = "SELECT * FROM pt_tasks WHERE TaskTree = '$treeID' AND MyTask = $myTask;";
        }

        if (!$resultSELECT_pt_tasks = $connection->query($querySELECT_pt_tasks)) {
            return "Błąd połączenia z bazą danych! Task::getAllTasksList" . $connection->error;
        } else {
            while ($rowSELECT_pt_tasks = $resultSELECT_pt_tasks->fetch_assoc()) {
                // var_dump($rowSELECT_pt_tasks);
                $tasksList[] = $rowSELECT_pt_tasks;
            }
        }
        if (!empty($tasksList)) {
            return $tasksList;
        }
    }

    public static function getTaskNumberById(mysqli $connection, string $treeId)
    {
        $querySELECT_pt_tasks = "SELECT TaskNumber FROM pt_tasks WHERE id = '$treeId';";
        if (!$resultSELECT_pt_tasks = $connection->query($querySELECT_pt_tasks)) {
            return "Błąd połączenia z bazą danych! Task::getAllTasksList" . $connection->error;
        } else {
            while ($rowSELECT_pt_tasks = $resultSELECT_pt_tasks->fetch_assoc()) {
                $tasksName = $rowSELECT_pt_tasks['TaskNumber'];
            }
        }
        if (!empty($tasksName)) {
            return $tasksName;
        }
    }

    public static function setRelation(mysqli $connection, string $Task, string $TaskBlockedBy)
    {
        if (isset($Task) && $Task != '' && isset($TaskBlockedBy) && $TaskBlockedBy != '') {
            $queryINSERT_pt_tasks = "INSERT INTO pt_tasks_block (TaskBlockTaskNumber, TaskBlockByNumber) VALUES ('$Task', '$TaskBlockedBy');";
            if (!$connection->query($queryINSERT_pt_tasks)) {
                return "Błąd połączenia z bazą danych! Task::getAllTasksList" . $connection->error;
            } else {
                $infoLog['ok'][] = "Utworzono połączenie: zadanie " . $Task . " jest blokowane przez zdanie " . $TaskBlockedBy . " !";
            }
        } else {
            $infoLog['nok'][] = "Nie podano numeru zadania: Blokowane: (" . $Task . ") Blokujące (" . $TaskBlockedBy . ")!";
        }

        return $infoLog;
    }

    /**
     * Zadania które są blokowane przez podane zadanie
     */
    public static function getBlocksTasks(mysqli $connection, string $Task, string $param = null)
    {
        if ($param == null || $param == "by") {
            $querySELECT_pt_tasks_block = "SELECT * FROM pt_tasks_block WHERE TaskBlockTaskNumber = '$Task';";
        } elseif ($param == "s") {
            $querySELECT_pt_tasks_block = "SELECT * FROM pt_tasks_block WHERE TaskBlockByNumber = '$Task';";
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
                $querySelect = "SELECT * FROM pt_tasks WHERE TaskNumber IN ($tasks)";
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

}
