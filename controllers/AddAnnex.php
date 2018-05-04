<?php

if (empty($_POST["annexNumber"]) || empty($_POST["practiceStart"])
    || empty($_POST["practiceEnd"]) || empty($_POST["contractID"]) || empty($_POST["practiceType"])) {
    echo 'Some of fields empty!';
    return;
}

$annexNumber = $_POST["annexNumber"];
$practiceStart = $_POST["practiceStart"];
$practiceEnd = $_POST["practiceEnd"];
$contractID = $_POST["contractID"];
$practiceType_string = $_POST["practiceType"];

$sql = new mysqli('localhost', 'root', '');
if ($sql->connect_error) {
    echo 'SQL Connect error!';
    return;
}
$sql->set_charset('utf8');

$type = (int)$sql->query("SELECT * FROM opts.practice_types WHERE type='$practiceType_string'")->fetch_assoc()["pid"];
//var_dump($type);

$sql->query("INSERT INTO opts.annexes (annexNumber, practiceStart, practiceEnd, contractID, practiceType) VALUES ($annexNumber, '$practiceStart', '$practiceEnd', '$contractID', $type)");
if ($sql->errno) {
    echo 'Query error!';
    return;
} else {
    echo 'OK';
    return;
}