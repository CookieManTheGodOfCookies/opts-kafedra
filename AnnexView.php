<!DOCTYPE html>
<?php
session_start();
if ($_SESSION['role'] == 'OPTS') {
    $sql = new mysqli('localhost', 'root', '');
    if ($sql->connect_error) {
        echo 'SQL Connect error!!';
        return;
    }
    $sql->set_charset('utf8');
} else return;
if (empty($_GET["aid"])) return;
$annexID = $_GET["aid"];
$annex = $sql->query("SELECT annexNumber, contractID from opts.annexes WHERE annexID=$annexID")->fetch_assoc();
$annexNumber = $annex["annexNumber"];
$contractID = $annex["contractID"];

$contract = $sql->query("SELECT contractNumber, companyID FROM opts.contracts WHERE contractID=$contractID")
    ->fetch_assoc();

$contractNumber = $contract["contractNumber"];
$companyID = $contract["companyID"];

$compName = $sql->query("SELECT compName FROM opts.companies WHERE compID=$companyID")
    ->fetch_assoc()["compName"];

$studentsOnPractice = $sql->query("SELECT * FROM opts.students WHERE practiceID=$annexID");
?>
<head>
    <meta charset="utf-8">
    <title>
        Приложение № <?= $annexNumber ?>
    </title>
    <link rel="stylesheet" type="text/css" href="stylesheets/MainStyle.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/Navchik.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/AmazingBigTable.css">
    <script src="scripts/jquery-3.3.1.js"></script>
    <script src="scripts/RemoveStudent.js"></script>
    <style>
        #attach-student {
            float: right;
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
<!-- NAV -->
<ul class="nav">
    <li><a href="StudentList.php">Студенты</a></li>
    <?php
    if ($_SESSION['role'] == 'OPTS') {
        ?>
        <li><a href="CompaniesList.php">Компании</a></li>
    <?php } ?>
    <li><a href="index.php">Выход</a></li>
</ul>

<h2 style="text-align: center">Компания: <?= $compName ?></h2>
<h2 style="text-align: center">Контракт № <?= $contractNumber ?></h2>
<h2 style="text-align: center">Приложение № <?= $annexNumber ?></h2>

<h1 style="text-align: center">Список прикрепленных студентов</h1>
<a href="AddStudent.php?aid=<?=$annexID?>" id="attach-student">Добавить студента</a>
<table class="amazing-big-table">
    <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Отчество</th>
        <th>Студенческий</th>
        <th>Номер группы</th>
        <th></th>
    </tr>
    <?php
    for ($i = 0; $i < $studentsOnPractice->num_rows; $i++) {
        $student = $studentsOnPractice->fetch_assoc();
        $sid = $student["studentID"];
        ?>
        <tr>
            <td><?= $student["name"] ?></td>
            <td><?= $student["surname"] ?></td>
            <td><?= $student["patronymic"] ?></td>
            <td><?= $student["IDNumber"] ?></td>
            <td><?= $student["groupNumber"] ?></td>
            <td>
                <button type="button" class="remove-student" id="<?=$sid?>">Открепить</button>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

</body>