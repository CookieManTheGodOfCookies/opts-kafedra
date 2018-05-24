<!DOCTYPE html>
<?php session_start(); ?>

<head>
    <title> Выберите студента</title>
    <meta charset="utf-8">
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
    <script src="scripts/jquery-3.3.1.js"></script>
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
        <?php } else return; ?>
    </ul>
    <ul class="navbar-nav nav navbar-right ml-auto">
        <li class="navbar-item"><a class="nav-link" href="index.php">Выход</a></li>
    </ul>

</nav>

<?php
if (empty($_GET["aid"])) return;
$aid = $_GET["aid"];

$sql = new mysqli('localhost', 'root', '');
if ($sql->connect_error) return;
$sql->set_charset('utf8');
$studentsWithoutPractice = $sql->query("SELECT * FROM opts.students WHERE practiceID IS NULL");
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="CompaniesList.php">Компании</a></li>
        <li class="breadcrumb-item"><a href="CompanyView.php?id=<?=$companyID?>">Контракты</a></li>
        <li class="breadcrumb-item"><a href="ContractView.php?id=<?=$contractID?>">Приложения</a></li>
        <li class="breadcrumb-item"><a href="AnnexView.php?aid=<?=$aid?>">Студенты</a></li>
        <li class="breadcrumb-item active" aria-current="page">Прикрепление студента</li>
    </ol>
</nav>

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
    for ($i = 0; $i < $studentsWithoutPractice->num_rows; $i++) {
        $studentWP = $studentsWithoutPractice->fetch_assoc();
        ?>
        <tr>
            <td><?= $studentWP["name"] ?></td>
            <td><?= $studentWP["surname"] ?></td>
            <td><?= $studentWP["patronymic"] ?></td>
            <td><?= $studentWP["IDNumber"] ?></td>
            <td><?= $studentWP["groupNumber"] ?></td>
            <td>
                <button type="button" class="btn btn-secondary attach" id="<?= $studentWP["studentID"] ?>">Выбрать</button>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    <script>
        var aid = <?=$aid?>;
        var anUrl = 'controllers/AttachStudent.php';
        $(document).ready(function () {
            $('.attach').click(function () {
                $.ajax({
                    type: 'POST',
                    url: anUrl,
                    data: {
                        "studentID": $(this).attr('id'),
                        "annexID": aid
                    },
                    success: function (reply) {
                        if (reply === 'OK') {
                            window.location.href = 'AnnexView.php?aid=' + aid;
                        }
                        else {
                            console.log(reply);
                        }
                    }
                });
            });
        });
    </script>
</table>
</body>