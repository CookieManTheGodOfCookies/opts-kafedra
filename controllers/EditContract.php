<?php
include_once ('../utils/test_input.php');
if(empty($_POST["contractID"])
    || empty($_POST["contractNumber"])
    || empty($_POST["dateOfContract"])
    || empty($_POST["expirationDate"]))
{
    echo 'Empty';
    return;
}

$contractID = test_input($_POST["contractID"]);
$contractNumber = test_input($_POST["contractNumber"]);
$dateOfContract = test_input($_POST["dateOfContract"]);
$expirationDate = test_input($_POST["expirationDate"]);

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$sql->query("UPDATE opts.contracts SET contractNumber=$contractNumber, dateOfContract='$dateOfContract', expirationDate='$expirationDate' WHERE contractID=$contractID");
if($sql->errno)
{
    echo 'Dublicate';
    return;
}
else echo 'OK';