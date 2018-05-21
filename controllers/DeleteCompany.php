<?php
if(empty($_POST['compID']))
{
    echo 'ID is empty!';
    return;
}

$compID = $_POST['compID'];

$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf-8');

$contractResult = $sql->query("SELECT * FROM opts.contracts WHERE companyID=$compID");
if($contractResult->num_rows == 0) {
    $sql->query("DELETE FROM opts.companies WHERE compID=$compID");
    echo 'OK';
}
else {
    for($i = 0; $i < $contractResult->num_rows; $i++)
    {
        $contract = $contractResult->fetch_assoc();
        $contractID = $contract["contractID"];
        $annexResult = $sql->query("SELECT * FROM opts.annexes WHERE contractID=$contractID");
        if($annexResult->num_rows == 0)
            $sql->query("DELETE FROM opts.contracts WHERE contractID=$contractID");
        else {
            for($j = 0; $j < $annexResult->num_rows; $j++)
            {
                $annex = $annexResult->fetch_assoc();
                $annexID = $annex["annexID"];
                $sql->query("UPDATE opts.students SET practiceID=NULL WHERE practiceID=$annexID");
                $sql->query("DELETE FROM opts.annexes WHERE annexID=$annexID");
            }
            $sql->query("DELETE FROM opts.contracts WHERE contractID=$contractID");
        }
    }
    $sql->query("DELETE FROM opts.companies WHERE compID=$compID");
    echo 'OK';
}