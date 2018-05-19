<?php
if(empty($_POST['compID']) ||
    empty($_POST['compName'])
    || empty($_POST['contactInfo']))
{
    echo 'Empty';
    return;
}
$compID = $_POST['compID'];
$compName = $_POST['compName'];
$contactInfo = $_POST['contactInfo'];
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');

$sql->query("UPDATE opts.companies SET compName='$compName', contactInfo='$contactInfo' WHERE compID=$compID");
if($sql->errno)
{
    echo 'Dublicate';
    return;
}
else echo 'OK';