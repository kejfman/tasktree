<?php
require_once '../entryPoint.php';

require_once '../class/Task.php';


if (isset($_REQUEST['MyTask']) && $_REQUEST['MyTask'] == 'on') {
    $_REQUEST['MyTask'] = 1;
} else {
    $_REQUEST['MyTask'] = 0;
}

$taskDetails = [
    'TaskTree' => $_REQUEST['TaskTree'],
    'TaskNumber' => $_REQUEST['TaskNumber'],
    'TaskOwner' => $_REQUEST['TaskOwner'],
    'TaskType' => $_REQUEST['TaskType'],
    'MyTask' => $_REQUEST['MyTask']
];

for ($i = 0; $i < count($_POST['TaskNumberBlocks']); $i++) {
    if ($_POST['TaskTree'] != '' && $_POST['TaskNumberBlocks'][$i] != '') {
        $taskDetails['TaskBlocks'][$i]['TaskTree'] = $_POST['TaskTree'];
        $taskDetails['TaskBlocks'][$i]['TaskNumber'] = $_POST['TaskNumberBlocks'][$i];
    }
}

for ($i = 0; $i < count($_POST['TaskOwnerBlocks']); $i++) {
    if ($_POST['TaskOwnerBlocks'][$i] != '') {
        $taskDetails['TaskBlocks'][$i]['TaskOwner'] = $_POST['TaskOwnerBlocks'][$i];
    }
}

for ($i = 0; $i < count($_POST['TaskTypeBlocks']); $i++) {
    if ($_POST['TaskTypeBlocks'][$i] != '') {
        $taskDetails['TaskBlocks'][$i]['TaskType'] = $_POST['TaskTypeBlocks'][$i];
    }
}


for ($i = 0; $i < count($_POST['TaskNumberBlocked']); $i++) {
    if ($_POST['TaskTree'] != '' && $_POST['TaskNumberBlocked'][$i] != '') {
        $taskDetails['TaskBlockedBy'][$i]['TaskTree'] = $_POST['TaskTree'];
        $taskDetails['TaskBlockedBy'][$i]['TaskNumber'] = $_POST['TaskNumberBlocked'][$i];
    }
}

for ($i = 0; $i < count($_POST['TaskOwnerBlocked']); $i++) {
    if ($_POST['TaskOwnerBlocked'][$i] != '') {
        $taskDetails['TaskBlockedBy'][$i]['TaskOwner'] = $_POST['TaskOwnerBlocked'][$i];
    }
}

for ($i = 0; $i < count($_POST['TaskTypeBlocked']); $i++) {
    if ($_POST['TaskTypeBlocked'][$i] != '') {
        $taskDetails['TaskBlockedBy'][$i]['TaskType'] = $_POST['TaskTypeBlocked'][$i];
    }
}

if (isset($_POST['selectedBlocksTasks']) && $_POST['selectedBlocksTasks'] != '') {
    $selectedBlocksTasks = explode(",", $_POST['selectedBlocksTasks']);
    for ($i = 0; $i < count($selectedBlocksTasks); $i++) {
        $taskName = Task::getTaskNumberById($db_connect, $selectedBlocksTasks[$i]);
        $selectedBlocksTasksLog = Task::setRelation($db_connect, $taskName, $taskDetails['TaskNumber']);

        var_dump($selectedBlocksTasksLog);
    }
}

if (isset($_POST['selectedBlockedTasks']) && $_POST['selectedBlockedTasks'] != '') {
    $selectedBlockedTasks = explode(",", $_POST['selectedBlockedTasks']);
    for ($i = 0; $i < count($selectedBlockedTasks); $i++) {
        $taskName = Task::getTaskNumberById($db_connect, $selectedBlockedTasks[$i]);
        $selectedBlockedTasksLog = Task::setRelation($db_connect, $taskDetails['TaskNumber'], $taskName);

        var_dump($selectedBlockedTasksLog);
    }
}

// var_dump($taskDetails);

$newTaskLog = Task::addNewTask($db_connect, $taskDetails);


// var_dump($newTaskLog);
