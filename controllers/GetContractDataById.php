<?php
include_once ('../utils/test_input.php');
if(empty($_POST['contractID']))
{
    echo 'empty id!';
    return;
}

$contractID = test_input($_POST['contractID']);
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');

$res = $sql->query("SELECT * FROM opts.contracts WHERE contractID=$contractID");
header('Content-Type: application/json');
echo json_encode($res->fetch_assoc());
