<?php
include_once ('../utils/test_input.php');
if(empty($_POST['compID']))
{
    echo 'Empty id!';
    return;
}

$compID = test_input($_POST['compID']);

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$row = $sql->query("SELECT * FROM opts.companies WHERE compID=$compID");
$company = $row->fetch_assoc();
header('Content-Type: application/json');
echo json_encode($company);