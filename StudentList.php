<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <!-- JQuery -->
    <script src="scripts/jquery-3.3.1.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="stylesheets/custom_styles.css">
    <title>Список студентов</title>

</head>
<body>

<!-- there will be some NAV -->
<nav class="navbar navbar-default sticky-top">
    <div class="container-fluid">
        <!-- Links -->
        <div class="navbar-header">
            <div class="navbar-brand">OPTS</div>
        </div>
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="StudentList.php">Студенты</a>
            </li>
            <?php
            if ($_SESSION['role'] == 'OPTS') {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="CompaniesList.php">Компании</a>
                </li>
                <?php
            }
            ?>
        </ul>
        <ul class="nav navbar-nav navbar-right ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Выход</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <?php
    // It gets the table with students from DB
    $sql = new mysqli('localhost', 'root', '');
    $sql->set_charset('utf8');
    if ($sql->connect_error) {
        echo "SQL Connect error!";
        $table = null;
        return;
    } else {
        $query = "SELECT * FROM opts.students";
        $table = $sql->query($query);
    }
    ?>
    <!-- a table -->
    <table class="table table-bordered table-hover" style="margin-top: 15px">
        <!-- HEADERS -->
        <thead>
        <tr>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Отчество</th>
            <th>Студенческий</th>
            <th>Группа</th>
            <th>Практика</th>
        </tr>
        </thead>
        <tbody>
        <?php
                foreach ($table as $row) {
            ?>
            <tr>
                <td class="student-id" id="<?= $row['studentID'] ?>" hidden></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['surname'] ?></td>
                <td><?php echo $row['patronymic'] ?></td>
                <td><?php echo $row['IDNumber'] ?></td>
                <td><?php echo $row['groupNumber'] ?></td>
                <td><?php if ($row['practiceID'] == NULL) {
                        echo "НЕТ";
                    } else { // practiceID is a foreign key to annexID
                        // now there will be some magic
                        $sid = $row['studentID'];
                        $practiceID = $sql->query("SELECT practiceID FROM opts.students WHERE studentID=$sid")->fetch_assoc()['practiceID'];
                        $contractID = $sql->query("SELECT contractID FROM opts.annexes WHERE annexID=$practiceID")->fetch_assoc()['contractID'];
                        $companyID = $sql->query("SELECT companyID FROM opts.contracts WHERE contractID=$contractID")->fetch_assoc()['companyID'];
                        $compName = $sql->query("SELECT compName FROM opts.companies WHERE compID=$companyID")->fetch_assoc()['compName'];
                        $contractNumber = $sql->query("SELECT contractNumber FROM opts.contracts WHERE contractID=$contractID")->fetch_assoc()['contractNumber'];
                        $annexNumber = $sql->query("SELECT annexNumber FROM opts.annexes WHERE annexID=$practiceID")->fetch_assoc()['annexNumber'];

                        echo "<p>Компания: $compName</p>";
                        echo "<p>Номер контракта: $contractNumber</p>";
                        echo "<p>Приложение №$annexNumber</p>";
                    } ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>