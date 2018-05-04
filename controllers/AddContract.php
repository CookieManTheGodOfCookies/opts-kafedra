<?php

if(empty($_POST["contractNumber"]) || empty($_POST["expirationDate"]) || empty($_POST["dateOfContract"]) || empty($_POST["compID"]))
{
    echo "Some of fields is empty!";
    return;
}

$cNumber = $_POST["contractNumber"];
$eDate = $_POST["expirationDate"];
$dOC = $_POST["dateOfContract"];
$cID = $_POST["compID"];

$sql = new mysqli('localhost', 'root', '');
if($sql->connect_error)
{
    echo "SQL Connect error!";
    return;
}
$sql->set_charset("utf8");

$query = "INSERT INTO opts.contracts (contractNumber, dateOfContract, expirationDate, companyID) VALUES ($cNumber, '$eDate', '$dOC', $cID)";
$sql->query($query);
if($sql->errno)
{
    echo $sql->error;
    return;
}
else
{
    echo 'OK';
    return;
}