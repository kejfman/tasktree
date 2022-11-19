<?php



class Tree
{
    private $TreeName = null; // nazwa drzewa zadań
    private $CreateDateTime = null; // data utworzenia drzewa zadań
    private $Done = null; // znacznik czy drzewo zostało ukończone
    private $DoneDateTime = null; // data ukończenia drzewa zadań


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
            return "Błąd połczenia z bazą danych! Tree::addNewTree - " . $connection->error;
        } else {
            if ($rowSelect_pt_trees_check = $resultSelect_pt_trees_check->fetch_assoc() <= 0) {
                $queryInsert_pt_trees = "INSERT INTO pt_trees (TreeName, TreeEnv, CreateDateTime)
                                        VALUES ('$TreeName', '$TreeEnv', '$now')";
                if (!$connection->query($queryInsert_pt_trees)) {
                    return "Błąd połczenia z bazą danych! Tree::addNewTree - " . $connection->error;
                } else {
                    $infoLog['ok'][] = "Utworzono drzewo  o nazwie <b>" . $TreeName . "</b>!";
                }
            } else {
                $infoLog['nok'][] = "Drzewo " . $TreeName . " już istnieje!";
            }
        }
    }


    public static function deleteTree(mysqli $connection, array $treeDetails)
    {
        if (!isset($treeDetails['TreeId']) || $treeDetails['TreeId'] == '') {
            return 'Nie podano ID Drezwa!';
        }

        $TreeId = $treeDetails['TreeId'];
        $infoLog = array();

        $queryDelete_pt_trees = "DELETE FROM pt_trees WHERE id in ($TreeId);";
        if (!$connection->query($queryDelete_pt_trees)) {
            return "Błąd połczenia z bazą danych! Tree::addNewTree - " . $connection->error;
        } else {
            $infoLog['ok'][] = "Utworzono drzewo  o nazwie <b>" . $TreeId . "</b>!";
        }
    }


    public static function getTreesList(mysqli $connection)
    {
        $querySelect_pt_trees = "SELECT * FROM pt_trees ORDER BY CreateDateTime;";
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

    public static function getTasksList(mysqli $db_connect, string $treeID, int $myTask = null)
    {
        global $db_connect;
        if ($myTask == null) {
            $querySELECT_pt_tasks = "SELECT * FROM pt_tasks WHERE TaskTree = '$treeID';";
        } else {
            $querySELECT_pt_tasks = "SELECT * FROM pt_tasks WHERE TaskTree = '$treeID' AND MyTask = $myTask;";
        }

        if (!$resultSELECT_pt_tasks = $db_connect->query($querySELECT_pt_tasks)) {
            return "Błąd połączenia z bazą danych! Task::getAllTasksList" . $db_connect->error;
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


    public static function getTreeChart(mysqli $connection, string $id)
    {
        $treeTasks = self::getTasksList($connection, $id);
        $allTasks = 0;
        $doneTasks = 0;
        $notDoneTasks = 0;

        $myTasks = 0;
        $myDoneTasks = 0;
        $myNotDoneTasks = 0;

        //  var_dump($treeTasks);
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

        // echo 'Wszystkie zadania: ' .  $allTasks . '<br />';
        // echo 'Wszystkie otwarte zadania: ' .  $notDoneTasks . '<br />';
        // echo 'Wszystkie zakończone zadania: ' .  $doneTasks . '<br /><br />';

        // echo 'Wszystkie moje zadania: ' .  $myTasks . '<br />';
        // echo 'Wszystkie moje otwarte zadania: ' .  $myNotDoneTasks . '<br />';
        // echo 'Wszystkie moje zakończone zadania: ' .  $myDoneTasks . '<br /><br />';


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
