<!DOCTYPE html>
<?php session_start(); ?>

<head>
    <title> Выберите студента</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="stylesheets/MainStyle.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/AmazingBigTable.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/Navchik.css">
    <script src="scripts/jquery-3.3.1.js"></script>
</head>
<body>
<!-- NAV -->
<ul class="nav">
    <li><a href="StudentList.php">Студенты</a></li>
    <?php
    if ($_SESSION['role'] == 'OPTS') {
        ?>
        <li><a href="CompaniesList.php">Компании</a></li>
    <?php } else return; ?>
    <li><a href="index.php">Выход</a></li>
</ul>

<?php
if(empty($_GET["aid"])) return;
$aid = $_GET["aid"];

$sql = new mysqli('localhost', 'root', '');
if($sql->connect_error) return;
$sql->set_charset('utf8');
$studentsWithoutPractice = $sql->query("SELECT * FROM opts.students WHERE practiceID is NULL");
?>

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
    for($i = 0; $i < $studentsWithoutPractice->num_rows; $i++) {
        $studentWP = $studentsWithoutPractice->fetch_assoc();
        ?>
        <tr>
            <td><?=$studentWP["name"]?></td>
            <td><?=$studentWP["surname"]?></td>
            <td><?=$studentWP["patronymic"]?></td>
            <td><?=$studentWP["IDNumber"]?></td>
            <td><?=$studentWP["groupNumber"]?></td>
            <td>
                <button type="button" class="attach" id="<?=$studentWP["studentID"]?>">Выбрать</button>
            </td>
        </tr>
        <?php
    }
    ?>
<script>
    var aid = <?=$aid?>;
        var anUrl = 'controllers/AttachStudent.php';
    $(document).ready(function () {
        $('.attach').click(function () {
            $.ajax({
                type: 'POST',
                url: anUrl,
                data: {
                    "studentID" : $(this).attr('id'),
                    "annexID" : aid
                },
                success: function (reply) {
                    if(reply === 'OK') {
                        alert("Done!");
                        window.location.href = 'AnnexView.php?aid=' + aid;
                    }
                    else
                    {
                        alert('Shit happened! Check console!');
                        console.log(reply);
                    }
                }
            });
        });
    });
</script>
</table>
</body>