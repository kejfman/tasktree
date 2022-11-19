<?php
require_once '../entryPoint.php';

require_once '../class/Tree.php';

$treeDetails['TreeName'] = $_REQUEST['addTreeName'];
$treeDetails['TreeEnv'] = $_REQUEST['TreeEnv'];

echo Tree::addNewTree($db_connect, $treeDetails);
