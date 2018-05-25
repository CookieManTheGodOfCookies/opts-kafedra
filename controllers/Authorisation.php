<?php
include_once('../utils/test_input.php');
session_start();
$sql_u = 'root';
$sql_h = 'localhost';
$sql_p = '';

$sql = new mysqli($sql_h, $sql_u, $sql_p);
if ($sql->connect_error) {
    echo 'SQL Connection Error...';
    return;
}

if (empty($_POST["username"]) || empty($_POST["password"])) {
    echo "Some of fields is empty!";
    return;
}

$uname = test_input($_POST["username"]);
    $pwd = test_input($_POST["password"]);
    $query = "SELECT userID, role FROM opts.users WHERE username='$uname' AND password='$pwd'";

    $result = $sql->query($query);
    if ($result->num_rows == 0) {
        echo "Invalid data!";
        return;
    } else {
        $row = $result->fetch_assoc();
        $_SESSION['uid'] = $row['userID'];
        $_SESSION['role'] = $row['role'];
        echo 'OK';
    }
