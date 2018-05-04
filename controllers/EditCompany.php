<?php
if(empty($_POST['compID']) ||
    empty($_POST['compName']))
{
    echo 'Empty data!';
    return;
}
$compID = $_POST['compID'];
$compName = $_POST['compName'];
//$compName = iconv('cp1251', 'UTF-8', $compName);
$contactInfo = $_POST['contactInfo'];
//$contactInfo = iconv('1251', 'UTF-8', $contactInfo);
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');

$sql->query("UPDATE opts.companies SET compName='$compName', contactInfo='$contactInfo' WHERE compID=$compID");
if($sql->errno)
{
    echo $sql->error;
    return;
}
else echo 'OK';