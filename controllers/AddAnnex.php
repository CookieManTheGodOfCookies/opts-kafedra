<?php

if (empty($_POST["annexNumber"]) || empty($_POST["practiceStart"])
    || empty($_POST["practiceEnd"]) || empty($_POST["contractID"]) || empty($_POST["practiceType"])) {
    echo 'Empty';
    return;
}

$annexNumber = $_POST["annexNumber"];
$practiceStart = $_POST["practiceStart"];
$practiceEnd = $_POST["practiceEnd"];
$contractID = $_POST["contractID"];
$practiceType_string = $_POST["practiceType"];

$sql = new mysqli('localhost', 'root', '');

$sql->set_charset('utf8');

$type = (int)$sql->query("SELECT * FROM opts.practice_types WHERE type='$practiceType_string'")->fetch_assoc()["pid"];

$sql->query("INSERT INTO opts.annexes (annexNumber, practiceStart, practiceEnd, contractID, practiceType) VALUES ($annexNumber, '$practiceStart', '$practiceEnd', '$contractID', $type)");
if ($sql->errno) {
    echo 'Dublicate';
    return;
} else {
    echo 'OK';
    return;
}