<?php
if(empty($_POST["annexID"]))
{
    echo 'error';
    return;
}

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$annexID = $_POST["annexID"];

$result = $sql->query("SELECT * FROM opts.annexes WHERE annexID=$annexID");
$annex = $result->fetch_assoc();
$pid = $annex["practiceType"];
$type = $sql->query("SELECT type FROM opts.practice_types WHERE pid=$pid")->fetch_assoc()["type"];
$annex["practiceType"] = $type;
header('Content-Type: application/json');
echo json_encode($annex);