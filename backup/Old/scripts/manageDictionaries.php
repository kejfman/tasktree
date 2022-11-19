<?php
require_once '../entryPoint.php';
require_once '../class/Dictionary.php';

if (isset($_REQUEST['add'])) {
    Dictionary::addToDictionary($db_connect, $_GET['dict'], $_GET['value']);
} elseif (isset($_REQUEST['dell'])) {
    Dictionary::deleteValueDictionary($db_connect, $_GET['id']);
}
