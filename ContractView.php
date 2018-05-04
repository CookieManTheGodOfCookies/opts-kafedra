<!DOCTYPE html>

<?php
session_start();
?>
<head>
    <title>

    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="stylesheets/MainStyle.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/Navchik.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/AmazingBigTable.css">
    <script src="scripts/jquery-3.3.1.js"></script>
    <script src="scripts/adders/AddAnnexModal.js"></script>
    <style>
        #add-annex {
            background-color: black;
            color: white;
            float: right;
        }

        #add-annex-modal {
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            position: absolute;
            background-color: rgba(0, 0, 0, 0.4);
            display: none;
        }

        .add-annex-modal-content {
            width: 40%;
            margin: 15% auto;
            height: auto;
            border: 1px solid black;
            padding: 14px;
            background-color: white;
        }

        .close {
            font-size: 18px;
            font-weight: bold;
            float: right;
            color: rgba(0, 0, 0, 0.4)
        }

        .close:hover {
            cursor: pointer;
            color: black;
        }

        .modal-form-submit {
            color: white;
            background-color: black;
            width: 100%;
        }

        .inp-label {
            width: 100%;
            margin-bottom: 5px;
        }

        .text-input {
            line-height: 30px;
            width: 100%;
            margin-bottom: 5px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.showAnnexInfo').click(function () {
                window.location.href = 'http://localhost/opts-kafedra/AnnexView.php?aid=' + $(this).attr('id');
            });
        });
    </script>
</head>
<body>
<ul class="nav">
    <li><a href="StudentList.php">Студенты</a></li>
    <?php
    if ($_SESSION['role'] == 'OPTS') {

        $sql = new mysqli('localhost', 'root', '');
        if ($sql->connect_error) {
            echo 'SQL Connect error!!';
            return;
        }
        $sql->set_charset('utf8');
        $contractID = $_GET['id'];
        $contract = $sql->query("SELECT contractNumber, companyID FROM opts.contracts WHERE contractID=$contractID")->fetch_assoc();
        $companyID = $contract["companyID"];
        $company = $sql->query("SELECT compName FROM opts.companies WHERE compID=$companyID")->fetch_assoc();
        $annexes = $sql->query("SELECT annexID, annexNumber, practiceStart, practiceEnd, practiceType FROM opts.annexes WHERE contractID=$contractID");
        ?>
        <li><a href="CompaniesList.php">Компании</a></li>
    <?php } ?>
    <li><a href="index.php">Выход</a></li>
</ul>

<h2 style="text-align: center">Компания: <?= $company["compName"] ?></h2>
<h3 style="text-align: center">Контракт: <?= $contract["contractNumber"] ?></h3>

<button type="button" id="add-annex">Добавить приложение</button>
<table class="amazing-big-table">
    <tr>
        <th>
            Номер приложения
        </th>
        <th>
            Дата начала практики
        </th>
        <th>
            Дата конца практики
        </th>
        <th>
            Тип практики
        </th>
        <th></th>
        <th></th>
        <th></th>
    </tr>

    <?php
    for ($i = 0; $i < $annexes->num_rows; $i++) {
        $annex = $annexes->fetch_assoc();
        $pid = $annex["practiceType"];
        $ptype = $sql->query("SELECT type FROM opts.practice_types WHERE pid=$pid")->fetch_assoc()["type"];
        $aid = $annex["annexID"];
        ?>
        <tr>
            <td><?= $annex["annexNumber"] ?></td>
            <td><?= $annex["practiceStart"] ?></td>
            <td><?= $annex["practiceEnd"] ?></td>
            <td><?= $ptype ?></td>
            <td>
                <a href="AnnexView.php?aid=<?=$aid?>">Студенты</a>
            </td>
            <td>
                <button type="button" class="edit-annex" id="<?=$aid?>">Редактировать</button>
            </td>
            <td></td>
        </tr>
        <?php
    }
    ?>
</table>



<!-- МОДАЛОЧКА -->
<div id="add-annex-modal">
    <div class="add-annex-modal-content">
        <span class="close">&times;</span>
        <span class="contID" id="<?= $contractID ?>"></span>

        <form>
            <div class="inp-label">
                Номер
            </div>
            <input class="text-input" type="text" id="annexNumber" required>
            <div class="inp-label">
                Начало практики
            </div>
            <input class="text-input" type="date" id="practiceStart" required>
            <div class="inp-label">
                Конец практики
            </div>
            <input class="text-input" type="date" id="practiceEnd" required>
            <!-- Practice type select-->
            <div class="inp-label">
                Тип практики
            </div>
            <select id="practiceType" required style="margin-top: 2px">
                <option selected disabled>Выберите тип</option>
                <?php
                $practiceTypes = $sql->query("SELECT type FROM opts.practice_types");
                for ($i = 0; $i < $practiceTypes->num_rows; $i++) {
                    $type = $practiceTypes->fetch_assoc()["type"];
                    ?>
                    <option value="<?= $type ?>"><?= $type ?></option>
                    <?php
                }
                ?>
            </select>


            <button type="button" class="modal-form-submit" id="add-annex-submit">Добавить</button>
        </form>
    </div>
</div>
</body>