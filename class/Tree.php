<?php

/**
 * Klasa umożliwiająca zarządzanie drzewami zadań w aplikacji Task Tree
 * ©Copyright 2019
 * Karol Osica
 */

class Tree
{
    private $TreeName = null; // nazwa drzewa zadań
    private $CreateDateTime = null; // data utworzenia drzewa zadań
    private $Done = null; // znacznik czy drzewo zostało ukończone
    private $DoneDateTime = null; // data ukończenia drzewa zadań


    /**
     * Dodawanie nowego drzewa zadań
     * @var mysqli $connection - połączenie z bazą danych
     * @var array $treeDetails - tablica z danymi nowo tworzonego drzewa zadań
     */
    public static function addNewTree(mysqli $connection, array $treeDetails)
    {
        if (!isset($treeDetails['TreeName']) || $treeDetails['TreeName'] == '') {
            return 'Nie podano nazwy Drezwa!';
        }

        $TreeName = $treeDetails['TreeName'];
        $TreeEnv = $treeDetails['TreeEnv'];
        $now = date("Y-m-d H:i:s");
        $infoLog = array();

        //Sprawdzenie czy drzewo o podanej nazwie już istnieje
        $querySelect_pt_trees_check = "SELECT id FROM pt_trees WHERE TreeName = '" . $TreeName . "';";

        if (!$resultSelect_pt_trees_check = $connection->query($querySelect_pt_trees_check)) {
            $infoLog['nok'][] = "Błąd połczenia z bazą danych! Tree::addNewTree - " . $connection->error . "<br /><b>Skontaktuj się z administratorem!</b>";
        } else {
            if ($rowSelect_pt_trees_check = $resultSelect_pt_trees_check->fetch_assoc() <= 0) {
                $queryInsert_pt_trees = "INSERT INTO pt_trees (TreeName, TreeEnv, CreateDateTime)
                                        VALUES ('$TreeName', '$TreeEnv', '$now')";
                if (!$connection->query($queryInsert_pt_trees)) {
                    $infoLog['nok'][] = "Błąd połczenia z bazą danych! Tree::addNewTree - " . $connection->error . "<br /><b>Skontaktuj się z administratorem!</b>";
                } else {
                    $infoLog['ok'][] = "Utworzono drzewo  o nazwie <b>" . $TreeName . "</b>!";
                }
            } else {
                $infoLog['nok'][] = "Drzewo " . $TreeName . " już istnieje!";
            }
        }

        return $infoLog;
    }

    /**
     * Usuwanie drzewa zadań
     * @var mysqli $connection - połączenie z bazą danych
     * @var array $treeDetails - tablica z danymi nowo tworzonego drzewa zadań
     */
    public static function deleteTree(mysqli $connection, array $treeDetails)
    {
        if (!isset($treeDetails['TreeId']) || $treeDetails['TreeId'] == '') {
            return 'Nie podano ID Drezwa!';
        }

        $TreeId = $treeDetails['TreeId'];
        $infoLog = array();

        $queryDelete_pt_trees = "DELETE FROM pt_trees WHERE id in ($TreeId);";
        if (!$connection->query($queryDelete_pt_trees)) {
            $infoLog['nok'][] = "Błąd połczenia z bazą danych! Tree::addNewTree - " . $connection->error . "<br /><b>Skontaktuj się z administratorem!</b>";
        } else {
            //dodatkowo usówamy powiązania pomiędzy drzewem i zadaniami:
            $queryUpdate = "UPDATE pt_tasks SET TaskTree = '' WHERE TaskTree in ($TreeId)";
            if (!$connection->query($queryUpdate)) {
                $infoLog['nok'][] = "Błąd połczenia z bazą danych! Tree::addNewTree - " . $connection->error . "<br /><b>Skontaktuj się z administratorem!</b>";
            }
            $infoLog['ok'][] = "Utworzono drzewo  o nazwie <b>" . $TreeId . "</b>!";
        }

        return $infoLog;
    }

    /**
     * Pobieranie listy drzew zadań
     * @var mysqli $connection - połączenie z bazą danych
     */
    public static function getTreesList(mysqli $connection)
    {
        $querySelect_pt_trees = "SELECT * FROM pt_trees ORDER BY CreateDateTime DESC;";
        if (!$resultSelecr_pt_trees = $connection->query($querySelect_pt_trees)) {
            return "Błąd połczenia z bazą danych! Tree::getTreesList - " . $connection->error;
        } else {
            while ($rowSelect_pt_trees = $resultSelecr_pt_trees->fetch_assoc()) {
                $TreesList[] = $rowSelect_pt_trees;
            }
        }
        if (!empty($TreesList)) {
            return $TreesList;
        }
    }

    /**
     * Pobieranie informacji na temat wybranego drzewa zadań
     * @var mysqli $connection - połączenie z bazą danych
     * @var string $id - identyfikator wybranego drzewa
     */
    public static function getTreeDetails(mysqli $connection, string $id)
    {
        $querySelect_pt_trees = "SELECT * FROM pt_trees WHERE id = '$id';";
        if (!$resultSelecr_pt_trees = $connection->query($querySelect_pt_trees)) {
            return "Błąd połczenia z bazą danych! Tree::getTreesList - " . $connection->error;
        } else {
            while ($rowSelect_pt_trees = $resultSelecr_pt_trees->fetch_assoc()) {
                $TreesDetails = $rowSelect_pt_trees;
            }
        }
        if (!empty($TreesDetails)) {
            return $TreesDetails;
        }
    }

    /**
     * Pobieranie listy zadań przypisanych do danego drzewa
     * @var mysqli $connection - połączenie z bazą danych
     * @var string $treeID - identyfikator drzewa
     * @var int $myTask - znacznik czy moje zadanie
     */
    public static function getTasksList(mysqli $db_connect, string $treeID, int $myTask = null)
    {
        global $db_connect;
        if ($myTask == null) {
            if ($treeID == 'all') {
                $querySELECT_pt_tasks = "SELECT * FROM pt_tasks;";
            } elseif ($treeID == 'all_free') {
                $querySELECT_pt_tasks = "SELECT * FROM pt_tasks WHERE TaskTree = '';";
            } else {
                $querySELECT_pt_tasks = "SELECT * FROM pt_tasks WHERE TaskTree = '$treeID';";  // dodany order by GM
            }
        } else {
            $querySELECT_pt_tasks = "SELECT * FROM pt_tasks WHERE TaskTree = '$treeID' AND MyTask = $myTask order by TaskType;";
        }

        if (!$resultSELECT_pt_tasks = $db_connect->query($querySELECT_pt_tasks)) {
            return "Błąd połączenia z bazą danych! Task::getAllTasksList" . $db_connect->error;
        } else {
            while ($rowSELECT_pt_tasks = $resultSELECT_pt_tasks->fetch_assoc()) {
                $tasksList[] = $rowSELECT_pt_tasks;
            }
        }
        if (!empty($tasksList)) {
            return $tasksList;
        }
    }



    /**
     * Tworzenie wykresu dla danego drzewa
     * @var mysqli $connection - połączenie z bazą danych
     * @var string $id - identyfikator drzewa
     */
    public static function getTreeChart(mysqli $connection, string $id)
    {
        $treeTasks = self::getTasksList($connection, $id);
        $allTasks = 0;
        $doneTasks = 0;
        $notDoneTasks = 0;

        $myTasks = 0;
        $myDoneTasks = 0;
        $myNotDoneTasks = 0;

        if ($treeTasks != null) {
            for ($i = 0; $i < count($treeTasks); $i++) {
                //wszystkie zadania
                $allTasks++;
                foreach ($treeTasks[$i] as $key => $value) {
                    // wszytkie moje zadania
                    if ($key == 'MyTask' && $value == 1) {
                        $myTasks++;
                    }
                    // zakończone zadania 
                    if ($key == 'Done' && $value == 1) {
                        //wszystkie zakończone zadania
                        $doneTasks++;
                        //moje zakończone zadaia
                        if ($treeTasks[$i]['MyTask'] == 1) {
                            $myDoneTasks++;
                        }
                    } elseif ($key == 'Done' && $value == 0) { // nie zakończone zadania 
                        //wszystkie niezakończone zadania
                        $notDoneTasks++;
                        //moje niezakończone zadaia
                        if ($treeTasks[$i]['MyTask'] == 1) {
                            $myNotDoneTasks++;
                        }
                    }
                }
            }
        }
        return $chartDetails = [
            'allTasks' => $allTasks,
            'notDoneTasks' => $notDoneTasks,
            'doneTasks' => $doneTasks,

            'myTasks' => $myTasks,
            'myNotDoneTasks' => $myNotDoneTasks,
            'myDoneTasks' => $myDoneTasks,
        ];
    }
}
