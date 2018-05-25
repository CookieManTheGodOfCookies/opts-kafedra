<?php
include_once ('../utils/test_input.php');
if(empty($_POST["studentID"]))
{
    echo "Empty id!";
    return;
}

$studentID = test_input($_POST["studentID"]);
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
$sql->query("UPDATE opts.students SET practiceID=NULL WHERE studentID=$studentID");
if($sql->errno)
{
    echo $sql->error;
    return;
}
else echo 'OK';