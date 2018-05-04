<?php
if(empty($_POST["annexNumber"])
    || empty($_POST["practiceStart"])
    || empty($_POST["practiceEnd"])
    || empty($_POST["practiceType"])
    || empty($_POST["annexID"]))
{
    echo 'Empty fields!';
    return;
}
$annexID = $_POST["annexID"];
$annexNumber = $_POST["annexNumber"];
$practiceStart = $_POST["practiceStart"];
$practiceEnd = $_POST["practiceEnd"];
$practiceType = $_POST["practiceType"];

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$pid = $sql->query("SELECT pid FROM opts.practice_types WHERE type='$practiceType'")->fetch_assoc()["pid"];
$sql->query("UPDATE opts.annexes SET annexNumber='$annexNumber', practiceStart='$practiceStart', practiceEnd='$practiceEnd', practiceType=$pid WHERE annexID=$annexID");
if($sql->errno)
{
    echo $sql->error;
    return;
}
else echo 'OK';