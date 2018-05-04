<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="stylesheets/MainStyle.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/Navchik.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/AmazingBigTable.css">
    <title>Список студентов</title>
    <script src="scripts/jquery-3.3.1.js"></script>
</head>
<body>

<!-- there will be some NAV -->
<ul class="nav">
    <li class="active"><a href="StudentList.php">Студенты</a></li>
    <?php
    if ($_SESSION['role'] == 'OPTS') {
        ?>
        <li><a href="CompaniesList.php">Компании</a></li>
    <?php } ?>
    <li><a href="index.php">Выход</a></li>
</ul>


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
<table class="amazing-big-table" style="margin-top: 20px">
    <!-- HEADERS -->
    <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Отчество</th>
        <th>Студенческий</th>
        <th>Группа</th>
        <th>Практика</th>
    </tr>
    <?php
    while ($row = $table->fetch_assoc()) {
        ?>
        <tr>
            <span class="student-id" id="<?= $row['studentID'] ?>"></span>
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

                    echo "<h3 style='text-align: center'>Компания: $compName</h3>";
                    echo "<p style='text-align: center'>Номер контракта: $contractNumber</p>";
                    echo "<p style='text-align: center'>Приложение №$annexNumber</p>";
                } ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>