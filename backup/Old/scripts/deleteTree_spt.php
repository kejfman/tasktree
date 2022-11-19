<?php
require_once '../entryPoint.php';

require_once '../class/Tree.php';

$treeDetails['TreeId'] = $_GET['deleteTree'];

Tree::deleteTree($db_connect, $treeDetails);

