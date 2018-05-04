<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Компании</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/MainStyle.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/Navchik.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/AmazingBigTable.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/AddModals.css">
    <script src="scripts/jquery-3.3.1.js"></script>
    <script src="scripts/adders/AddCompanyModal.js"></script>
    <script src="scripts/delete/DeleteCompany.js"></script>
    <script src="scripts/editors/EditCompanyModal.js"></script>
    <style>
        .big-text {
            line-height: 20px;
            width: 100%;
            wrap-option: wrap;
            height: 100px;
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

        .close {
            font-size: 18px;
            font-weight: bold;
            float: right;
            color: rgba(0,0,0,0.4)
        }

        .close:hover {
            cursor: pointer;
            color: black;
        }

        #add-company {
            float: right;
            background-color: black;
            color: white;
        }
        .company-modal {
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
            position: absolute;
        }

        .company-modal-content {
            width: 40%;
            height: auto;
            margin: 15% auto;
            background-color: white;
            border: 1px solid black;
            padding: 14px;
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
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
if ($sql->connect_error) {
    echo "SQL Connect error!";
    $table = null;
    return;
} else {
    $query = 'SELECT * FROM opts.companies';
    $table = $sql->query($query);
}
?>
<button type="button" id="add-company" style="margin-top: 20px">Добавить</button>

<table class="amazing-big-table" style="margin-top: 20px">
    <tr>
        <th>Название</th>
        <th>Контактная информация</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php
    for ($i = 0; $i < $table->num_rows; $i++) {
        $row = $table->fetch_assoc();
        $cid = $row["compID"];
        ?>
        <tr>
            <td><?php echo $row['compName'] ?></td>
            <td><?php echo $row['contactInfo'] ?></td>
            <td><a href="CompanyView.php?id=<?=$cid?>">Подробнее</a></td>
            <td>
                <button type="button" id="<?=$cid?>" class="edit-company">Редактировать</button>
            </td>
            <td>
                <button type="button" id="<?=$cid?>" class="delete-company">Удалить</button>
            </td>
        </tr>
    <?php }

    ?>
</table>



<!-- Add Company Modal -->
<div class="company-modal" id="add-company-modal">
    <div class="company-modal-content">
        <span class="close" id="close">&times;</span>
        <form id="add-company-form">
            <div class="inp-label">
                Название:
            </div>
            <input type="text" name="compName" class="text-input" required>

            <div class="inp-label">
                Контактная информация:
            </div>
            <textarea name="contactInfo" class="big-text" required></textarea>
            <input id="add-company-submit" class="modal-form-submit" type="button" name="submit" value="Добавить">
        </form>
    </div>
</div>

<!-- Edit Company Modal -->
<div class="company-modal" id="edit-company-modal">
    <div class="company-modal-content">
        <span class="close" id="close">&times;</span>
        <form id="edit-company-form">
            <div class="inp-label">
                Название:
            </div>
            <input type="text" name="compName" id="e-compName" class="text-input" required>
            <div class="inp-label">
                Контактная информация:
            </div>
            <textarea name="contactInfo" id="e-contactInfo" class="big-text" required></textarea>
            <input id="edit-company-submit" class="modal-form-submit" type="button" name="submit" value="Сохранить">
        </form>
    </div>
</div>

</body>
</html>