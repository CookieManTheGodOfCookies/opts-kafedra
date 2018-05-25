<!DOCTYPE html>

<?php
session_start();
include_once ('utils/test_input.php');
?>
<head>
    <title>
        Контракт
    </title>
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
    <script src="scripts/adders/AddAnnexModal.js"></script>
    <script src="scripts/editors/EditAnnexModal.js"></script>
    <script src="scripts/delete/DeleteAnnex.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="navbar-header">
        <div class="navbar-brand">
            OPTS
        </div>
    </div>
    <ul class="navbar-nav">
        <li class="navbar-item"><a class="nav-link" href="StudentList.php">Студенты</a></li>
        <?php
        if ($_SESSION['role'] == 'OPTS') {

            $sql = new mysqli('localhost', 'root', '');
            if ($sql->connect_error) {
                echo 'SQL Connect error!!';
                return;
            }
            $sql->set_charset('utf8');
            $contractID = test_input($_GET['id']);
            $contract = $sql->query("SELECT contractNumber, companyID FROM opts.contracts WHERE contractID=$contractID")->fetch_assoc();
            $companyID = $contract["companyID"];
            $company = $sql->query("SELECT compName FROM opts.companies WHERE compID=$companyID")->fetch_assoc();
            $annexes = $sql->query("SELECT annexID, annexNumber, practiceStart, practiceEnd, practiceType FROM opts.annexes WHERE contractID=$contractID");
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
        <li class="breadcrumb-item active" aria-current="page">Приложения</li>
    </ol>
</nav>

<h4 style="text-align: center">Компания: <?= $company["compName"] ?></h4>
<h5 style="text-align: center">Контракт: <?= $contract["contractNumber"] ?></h5>

<button type="button" class="btn" style="float:right" id="add-annex">Добавить приложение</button>
<table class="table table-bordered table-hover">
    <thead>
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
    </thead>
    <tbody>
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
                <button type="button" class="btn btn-secondary" onclick="location.href='AnnexView.php?aid=<?= $aid ?>'">
                    Студенты
                </button>
            </td>
            <td>
                <button type="button" class=" btn btn-secondary edit-annex" id="<?= $aid ?>">Редактировать</button>
            </td>
            <td>
                <button type="button" class="btn btn-secondary delete-annex" id="<?= $aid . "/" . $contractID ?>">
                    Удалить
                </button>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<!-- МОДАЛОЧКА -->
<div class="modal fade" id="add-annex-modal" tabindex="-1" role="dialog" aria-labelledby="add-annex-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <span class="contID" id="<?= $contractID ?>" hidden></span>
            <div class="modal-header">
                <h5 class="modal-title" id="add-annex-modal-label">Добавить приложение</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addAnnexForm">
                    <div class="form-group">
                        <label for="annexNumberInput-a" class="col-form-label">Номер:</label>
                        <input type="text" class="form-control" id="annexNumberInput-a">
                    </div>
                    <div class="form-group">
                        <label for="practiceStartInput-a" class="col-form-label">Начало практики:</label>
                        <input type="date" class="form-control" id="practiceStartInput-a">
                    </div>
                    <div class="form-group">
                        <label for="practiceEndInput-a" class="col-form-label">Конец практики:</label>
                        <input type="date" class="form-control" id="practiceEndInput-a">
                    </div>
                    <div class="form-group">
                        <label for="practiceTypeSelect-a" class="col-form-label">Тип практики:</label>
                        <select class="form-control" id="practiceTypeSelect-a">
                            <option selected disabled>Выберите тип</option>
                            <?php
                            $practiceTypes = $sql->query("SELECT * FROM opts.practice_types");
                            for ($i = 0; $i < $practiceTypes->num_rows; $i++) {
                                $type = $practiceTypes->fetch_assoc()["type"];
                                ?>
                                <option value="<?= $type ?>"><?= $type ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </form>
                <div class="w-100"></div>
                <div class="alert alert-danger show col-sm-12 col-md-12" id="addErrorAlert" role="alert"
                     style="display: none">
                    <p id="addErrorAlertText"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn" id="add-annex-submit">Добавить приложение</button>
            </div>
        </div>
    </div>
</div>

<!-- Модалка для редактирования -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-annex-modal-label" id="edit-annex-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-annex-modal-label">Редактировать приложение</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-annex-form">
                    <div class="form-froup">
                        <label for="annexNumberInput-e" class="col-form-label">Номер:</label>
                        <input type="text" class="form-control" id="annexNumberInput-e">
                    </div>
                    <div class="form-group">
                        <label for="practiceStartInput-e" class="col-form-label">Начало практики:</label>
                        <input type="date" class="form-control" id="practiceStartInput-e">
                    </div>
                    <div class="form-group">
                        <label for="practiceEndInput-e" class="col-form-label">Конец практики:</label>
                        <input type="date" class="form-control" id="practiceEndInput-e">
                    </div>
                    <div class="form-group">
                        <label for="practiceTypeSelect-e" class="col-form-label">Тип практики:</label>
                        <select id="practiceTypeSelect-e" class="form-control">
                            <option selected disabled>Выберите тип</option>
                            <?php
                            $practiceTypes = $sql->query("SELECT * FROM opts.practice_types");
                            for($i = 0; $i < $practiceTypes->num_rows; $i++) {
                                $type = $practiceTypes->fetch_assoc()['type'];
                                ?>
                                <option value="<?=$type?>"><?=$type?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="w-100"></div>
            <div class="alert alert-danger show col-sm-12 col-md-12" id="editErrorAlert" role="alert" style="display: none">
                <p id="editErrorAlertText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn" id="edit-annex-submit">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>

<!-- delete annex warning -->
<div class="modal fade" id="deleteWarning" tabindex="-1" role="dialog" aria-labelledby="deleteWarningLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteWarningLabel">Удаление контракта</h5>
                <button type="button" class="close" data-dismiss="modal" aria-labelledby="Close">
                    <span aria-hidden="true">&times</span></button>
            </div>
            <div class="modal-body">
                <p id="warningDialogText"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button class="btn btn-danger" id="deleteConfirm">Удалить</button>
            </div>
        </div>
    </div>
</div>

</body>