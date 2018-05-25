<!DOCTYPE html>
<?php
include_once ('utils/test_input.php');
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
$annexID = test_input($_GET["aid"]);
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
    <!-- JQuery -->
    <script src="scripts/jquery-3.3.1.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="stylesheets/custom_styles.css">
    <script src="scripts/RemoveStudent.js"></script>
</head>
<body>
<!-- NAV -->
<nav class="navbar navbar-dark bg-dark navbar-expand-sm">
    <div class="navbar-header">
        <div class="navbar-brand">
            OPTS
        </div>
    </div>
    <ul class="navbar-nav">
        <li class="navbar-item"><a class="nav-link" href="StudentList.php">Студенты</a></li>
        <?php
        if ($_SESSION['role'] == 'OPTS') {
            ?>
            <li class="navbar-item"><a class="nav-link" href="CompaniesList.php">Компании</a></li>
        <?php } ?>
    </ul>
    <ul class="navbar-nav nav navbar-right ml-auto">
        <li class="navbar-item"><a class="nav-link" href="index.php">Выход</a></li>
    </ul>

</nav>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="CompaniesList.php">Компании</a></li>
        <li class="breadcrumb-item"><a href="CompanyView.php?id=<?=$companyID?>">Контракты</a></li>
        <li class="breadcrumb-item"><a href="ContractView.php?id=<?=$contractID?>">Приложения</a></li>
        <li class="breadcrumb-item active" aria-current="page">Студенты</li>
    </ol>
</nav>

<h5 style="text-align: center">Компания: <?= $compName ?></h5>
<h5 style="text-align: center">Контракт № <?= $contractNumber ?></h5>
<h5 style="text-align: center">Приложение № <?= $annexNumber ?></h5>

<h5 style="text-align: center">Список прикрепленных студентов</h5>
<button type="button" class="btn" onclick="location.href='AddStudent.php?aid=<?=$annexID?>'" style="float: right">Добавить студента</button>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Отчество</th>
        <th>Студенческий</th>
        <th>Номер группы</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
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
                <button type="button" class="btn btn-danger remove-student" id="<?=$sid?>">Открепить</button>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

</body>