<?php
if(empty($_POST["annexID"]))
{
    echo "Empty id!";
    return;
}

$annexID = $_POST["annexID"];
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$sql->query("UPDATE opts.students SET practiceID=NULL WHERE practiceID=$annexID");
$sql->query("DELETE FROM opts.annexes WHERE annexID=$annexID");
if($sql->errno)
{
    echo $sql->error;
    return;
}
else echo 'OK';