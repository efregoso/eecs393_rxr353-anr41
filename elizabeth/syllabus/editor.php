<?php

if(isset($_POST['Course-Description'])&&!empty($_POST['Course-Description'])) {
        file_put_contents("Description.txt", "");
    $data = $_POST['Course-Description'] . "\n";
    $ret = file_put_contents('Description.txt', $data, FILE_APPEND | LOCK_EX);
    if($ret == false) {
        die('There was an error writing this file');
    }
}
if(isset($_POST['Objectives'])&&!empty($_POST['Objectives'])) {
        file_put_contents("data.txt", "");
    $data = $_POST['Objectives'] . "\n";
    $ret = file_put_contents('data.txt', $data, FILE_APPEND | LOCK_EX);
    if($ret == false) {
        die('There was an error writing this file');
    }
}
if(isset($_POST['Prerequisites'])&&!empty($_POST['Prerequisites'])) {
        file_put_contents("prerequisites.txt", "");
    $data = $_POST['Prerequisites'] . "\n";
    $ret = file_put_contents('prerequisites.txt', $data, FILE_APPEND | LOCK_EX);
    if($ret == false) {
        die('There was an error writing this file');
    }
}
if(isset($_POST['Project'])&&!empty($_POST['Project'])) {
        file_put_contents("project.txt", "");
    $data = $_POST['Project'] . "\n";
    $ret = file_put_contents('project.txt', $data, FILE_APPEND | LOCK_EX);
    if($ret == false) {
        die('There was an error writing this file');
    }

    else {
        echo "Class Information has been updated";
    }
}
?>



