<?php
include_once ('../utils/test_input.php');
if(empty($_POST["contractID"]))
{
    echo "Empty id!";
    return;
}

$contractID = test_input($_POST["contractID"]);
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');

$annexRes = $sql->query("SELECT * FROM opts.annexes WHERE contractID=$contractID");

if($annexRes->num_rows == 0) {
    $sql->query("DELETE FROM opts.contracts WHERE contractID=$contractID");
    echo 'OK';
} else {
    for($i = 0; $i < $annexRes->num_rows; $i++) {
        $annexID = $annexRes->fetch_assoc()["annexID"];
        $sql->query("UPDATE opts.students SET practiceID=NULL WHERE practiceID=$annexID");
        $sql->query("DELETE FROM opts.annexes WHERE annexID=$annexID");
    }
    $sql->query("DELETE FROM opts.contracts WHERE contractID=$contractID");
    echo 'OK';
}