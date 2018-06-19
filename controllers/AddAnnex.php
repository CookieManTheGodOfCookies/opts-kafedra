<?php
include_once ('../utils/test_input.php');
if (empty($_POST["annexNumber"]) || empty($_POST["practiceStart"])
    || empty($_POST["practiceEnd"]) || empty($_POST["contractID"]) || empty($_POST["practiceType"])) {
    echo 'Empty';
    return;
}

$annexNumber = test_input($_POST["annexNumber"]);
$practiceStart = test_input($_POST["practiceStart"]);
$practiceEnd = test_input($_POST["practiceEnd"]);
$contractID = test_input($_POST["contractID"]);
$practiceType_string = test_input($_POST["practiceType"]);

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