<?php
if(empty($_POST["contractID"]))
{
    echo "Empty id!";
    return;
}

$contractID = $_POST["contractID"];
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$sql->query("DELETE FROM opts.contracts WHERE contractID=$contractID");
if($sql->errno)
{
    echo $sql->error;
    return;
}
else echo 'OK';