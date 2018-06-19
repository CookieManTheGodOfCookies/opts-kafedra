<?php
include_once  ('../utils/test_input.php');
if(empty($_POST["contractNumber"]) || empty($_POST["expirationDate"]) || empty($_POST["dateOfContract"]) || empty($_POST["compID"]))
{
    echo "Empty";
    return;
}

$cNumber = test_input($_POST["contractNumber"]);
$eDate = test_input($_POST["expirationDate"]);
$dOC = test_input($_POST["dateOfContract"]);
$cID = test_input($_POST["compID"]);

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
    echo 'Dublicate';
    return;
}
else
{
    echo 'OK';
    return;
}