<?php

if(empty($_POST['compName']) || empty($_POST['contactInfo']))
{
    echo 'Empty';
    return;
}

$cName = $_POST['compName'];
$cInfo = $_POST['contactInfo'];

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
if($sql->connect_error)
{
    echo 'SQL Connect Error';
    return;
}

$query = "INSERT INTO opts.companies (compName, contactInfo) VALUES ('$cName', '$cInfo')";
$sql->query($query);
if($sql->errno) {
    echo 'Dublicate data';
    return;
}
else {
    echo 'OK';
    return;
}