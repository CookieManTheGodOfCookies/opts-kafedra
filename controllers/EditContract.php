<?php
if(empty($_POST["contractID"])
    || empty($_POST["contractNumber"])
    || empty($_POST["dateOfContract"])
    || empty($_POST["expirationDate"]))
{
    echo 'Fields empty!';
    return;
}

$contractID = $_POST["contractID"];
$contractNumber = $_POST["contractNumber"];
$dateOfContract = $_POST["dateOfContract"];
$expirationDate = $_POST["expirationDate"];

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$sql->query("UPDATE opts.contracts SET contractNumber=$contractNumber, dateOfContract='$dateOfContract', expirationDate='$expirationDate' WHERE contractID=$contractID");
if($sql->errno)
{
    echo $sql->error;
    return;
}
else echo 'OK';