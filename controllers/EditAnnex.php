<?php
include_once ('../utils/test_input.php');
if(empty($_POST["annexNumber"])
    || empty($_POST["practiceStart"])
    || empty($_POST["practiceEnd"])
    || empty($_POST["practiceType"])
    || empty($_POST["annexID"]))
{
    echo 'Empty';
    return;
}
$annexID = test_input($_POST["annexID"]);
$annexNumber = test_input($_POST["annexNumber"]);
$practiceStart = test_input($_POST["practiceStart"]);
$practiceEnd = test_input($_POST["practiceEnd"]);
$practiceType = test_input($_POST["practiceType"]);

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$pid = $sql->query("SELECT pid FROM opts.practice_types WHERE type='$practiceType'")->fetch_assoc()["pid"];
$sql->query("UPDATE opts.annexes SET annexNumber='$annexNumber', practiceStart='$practiceStart', practiceEnd='$practiceEnd', practiceType=$pid WHERE annexID=$annexID");
if($sql->errno)
{
    echo 'Dublicate';
    return;
}
else echo 'OK';