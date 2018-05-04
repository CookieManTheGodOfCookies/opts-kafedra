<?php
if(empty($_POST['compID']))
{
    echo 'ID is empty!';
    return;
}

$compID = $_POST['compID'];

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf-8');
$sql->query("DELETE FROM opts.companies WHERE compID=$compID");
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