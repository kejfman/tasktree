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
}
