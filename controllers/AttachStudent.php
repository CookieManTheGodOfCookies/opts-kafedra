<?php
include_once ('../utils/test_input.php');
$sql = new mysqli('localhost', 'root', '');
if($sql->connect_error)
{
    echo 'SQL Connect Error!';
    return;
}

if(empty($_POST["annexID"]) || empty($_POST["studentID"]))
{
    echo "Some data is empty! Tell the programmer he's a jerk.";
    return;
}

$annexID = test_input($_POST["annexID"]);
$studentID = test_input($_POST["studentID"]);

$sql->query("UPDATE opts.students SET practiceID=$annexID WHERE studentID=$studentID");
if($sql->errno)
{
    echo "Query error!";
    return;
}
else{ echo 'OK';}