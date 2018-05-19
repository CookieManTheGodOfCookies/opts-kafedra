<!DOCTYPE html>

<?php
session_start();
?>
<head>
    <title>Контракты компании <?= $compName ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="stylesheets/MainStyle.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/Navchik.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/AmazingBigTable.css">
    <script src="scripts/jquery-3.3.1.js"></script>
    <script src="scripts/adders/AddContractModal.js"></script>
    <script src="scripts/editors/EditContractModal.js"></script>
    <script src="scripts/delete/DeleteContract.js"></script>
    <script src="scripts/delete/DeleteCompany.js"></script>

    <style>
        #add-contract {
            float: right;
            background-color: black;
            color: white;
        }

        .contract-modal {
            width: 100%;
            height: 100%;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.4);
            top: 0;
            left: 0;
            display: none;
            position: absolute;
        }

        .contract-modal-content {
            width: 40%;
            height: auto;
            margin: 15% auto;
            background-color: white;
            border: 1px solid black;
            padding: 14px;
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

        .close , .close2 {
            font-size: 18px;
            font-weight: bold;
            float: right;
            color: rgba(0, 0, 0, 0.4)
        }

        .close:hover , .close2:hover{
            cursor: pointer;
            color: black;
        }

        .modal-form-submit {
            color: white;
            background-color: black;
            width: 100%;
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
        <li class="active"><a href="CompaniesList.php">Компании</a></li>
    <?php } ?>
    <li><a href="index.php">Выход</a></li>
</ul>

<?php
session_start();
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
if ($sql->connect_error) {
    echo "SQL Connect error!";
    return;
}
$id = $_GET["id"];
$compName = $sql->query("SELECT * FROM opts.companies WHERE compID=$id")->fetch_assoc()["compName"];
?>

<h1 style="text-align: center;">Контракты компании <?= $compName ?></h1>
<button type="button" id="add-contract">Добавить контракт</button>
<button type="button" id="<?=$id?>" class="delete-company" style="float: right; background-color: black; color: white">Удалить</button>
<table class="amazing-big-table">
    <tr>
        <th>
            Номер
        </th>
        <th>
            Дата заключения
        </th>
        <th>
            Дата окончания
        </th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php
    $contracts = $sql->query("SELECT contractID, contractNumber, dateOfContract, expirationDate FROM opts.contracts WHERE companyID=$id");

    for ($i = 0; $i < $contracts->num_rows; $i++) {
        $row = $contracts->fetch_assoc();
        $cid = $row["contractID"]
        ?>
        <tr>
            <td>
                <?= $row["contractNumber"] ?>
            </td>
            <td>
                <?= $row["dateOfContract"] ?>
            </td>
            <td>
                <?= $row["expirationDate"] ?>
            </td>
            <td>
                <a href="ContractView.php?id=<?=$cid?>">Приложения</a>
            </td>
            <td>
                <button type="button" id="<?=$cid?>" class="edit-contract">Редактировать</button>
            </td>
            <td>
                <button type="button" id="<?=$cid . "/" . $id?>" class="delete-contract">Удалить</button>
            </td>
        </tr>
        <?php
    }
    ?>
</table>


<!-- ОЧЕРЕДНАЯ УМОПОМРАЧИТЕЛЬНАЯ МОДАЛКА ДЛЯ ФАНАТОВ -->
<div id="add-contract-modal" class="contract-modal">
    <div class="contract-modal-content">
        <span class="close">&times;</span>
        <form id="add-contract-form">
            <span class="compID" id="<?= $id ?>"></span>
            <div class="inp-label">
                Номер:
            </div>
            <input type="text" id="contractNumber" class="text-input" required>
            <div class="inp-label">
                Дата заключения:
            </div>
            <input type="date" id="dateOfContract" class="text-input" required>
            <div class="inp-label">
                Дата окончания:
            </div>
            <input type="date" id="expirationDate" class="text-input" required>
            <button type="button" id="add-contract-submit" class="modal-form-submit">Добавить</button>
        </form>
    </div>
</div>

<!-- EDIT  CONTRACT   MODAL -->
<div id="edit-contract-modal" class="contract-modal">
    <div class="contract-modal-content">
        <span class="close2">&times;</span>
        <form id="edit-contract-form">
            <span class="compID" id="<?= $id ?>"></span>
            <div class="inp-label">
                Номер:
            </div>
            <input type="text" id="e-contractNumber" class="text-input" required>
            <div class="inp-label">
                Дата заключения:
            </div>
            <input type="date" id="e-dateOfContract" class="text-input" required>
            <div class="inp-label">
                Дата окончания:
            </div>
            <input type="date" id="e-expirationDate" class="text-input" required>
            <button type="button" id="edit-contract-submit" class="modal-form-submit">Сохранить</button>
        </form>
    </div>
</div>
</body>