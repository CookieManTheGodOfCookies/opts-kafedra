<!DOCTYPE html>
<html>
<?php
session_start();
include_once('utils/test_input.php');
?>
<head>
    <title>Контракты компании <?= $compName ?></title>
    <meta charset="utf-8">
    <!-- JQuery -->
    <script src="scripts/jquery-3.3.1.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">

    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="stylesheets/custom_styles.css">
    <!-- More JS -->
    <script src="scripts/adders/AddContractModal.js"></script>
    <script src="scripts/editors/EditContractModal.js"></script>
    <script src="scripts/delete/DeleteContract.js"></script>
    <script src="scripts/delete/DeleteCompany.js"></script>

</head>
<body>
<!-- NAV -->
<nav class="navbar navbar-default sticky-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="navbar-brand">OPTS</div>
        </div>
        <ul class="nav navbar-nav">
            <li class="navbar-item">
                <a class="nav-link" href="StudentList.php">Студенты</a>
            </li>
            <?php
            if ($_SESSION['role'] == 'OPTS') {
                ?>
                <li class="navbar-item">
                    <a class="nav-link" href="CompaniesList.php">Компании</a>
                </li>
                <?php
            }
            ?>
        </ul>
        <ul class="nav navbar-nav navbar-right nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Выход</a>
            </li>
        </ul>
    </div>
</nav>

<?php
session_start();
$sql = new mysqli('localhost', 'root', '');
$sql->set_charset('utf8');
if ($sql->connect_error) {
    echo "SQL Connect error!";
    return;
}
$id = test_input($_GET["id"]);
$compName = $sql->query("SELECT * FROM opts.companies WHERE compID=$id")->fetch_assoc()["compName"];
?>

<div class="container">
    <nav aria-label="breadcrumb" style="margin-top: 15px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="CompaniesList.php">Компании</a></li>
            <li class="breadcrumb-item active" aria-current="page">Контракты</li>
        </ol>
    </nav>

    <h4 style="text-align: center;">Контракты компании <?= $compName ?></h4>
    <span class="companyID" id="<?= $id ?>" hidden></span>
    <button type="button" class="btn btn-secondary addContract" id="add-contract" style="float: right">Добавить
        контракт
    </button>
    <button type="button" id="<?= $id ?>" class="deleteCompany btn btn-danger" style="float: right">Удалить компанию
    </button>
    <table class="table table-hover table-bordered">
        <thead>
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

        </tr>
        </thead>
        <tbody>
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
                    <button type="button" class="btn btn-secondary"
                            onclick="window.location.href='ContractView.php?id=<?= $cid ?>'">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </button>
                    <button type="button" id="<?= $cid ?>" class=" btn btn-secondary edit-contract">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <button type="button" id="<?= $cid . "/" . $id ?>" class="btn btn-danger delete-contract">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <!-- Add Contract Modal -->
    <div class="modal fade" id="addContractModal" tabindex="-1" role="dialog" aria-labelledby="addContractModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContractModalLabel">Добавить контракт</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addContractForm">
                        <div class="form-group">
                            <label for="contractNumberInput-a" class="col-form-label">Номер контракта:</label>
                            <input type="text" class="form-control" id="contractNumberInput-a">
                        </div>
                        <div class="form-group">
                            <label for="dateOfContractInput-a" class="col-form-label">Дата заключения:</label>
                            <input type="date" class="form-control" id="dateOfContractInput-a">
                        </div>
                        <div class="form-group">
                            <label for="expirationDateInput-a" class="col-form-label">Дата окончания:</label>
                            <input type="date" class="form-control" id="expirationDateInput-a">
                        </div>
                    </form>
                    <div class="w-100"></div>
                    <div class="alert alert-danger fade in" id="addErrorAlert" role="alert"
                         style="display: none">
                        <p id="addErrorAlertText"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn" id="addContractSubmit">Добавить контракт</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Contract Modal -->
    <div class="modal fade" id="editContractModal" tabindex="-1" role="dialog" aria-labelledby="editContractModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContractModalLabel">Редактировать контракт</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editContractForm">
                        <div class="form-group">
                            <label for="contractNumberInput-e" class="col-form-label">Номер контракта:</label>
                            <input type="text" class="form-control" id="contractNumberInput-e">
                        </div>
                        <div class="form-group">
                            <label for="dateOfContractInput-e" class="col-form-label">Дата заключения:</label>
                            <input type="date" class="form-control" id="dateOfContractInput-e">
                        </div>
                        <div class="form-group">
                            <label for="expirationDateInput-e" class="col-form-label">Дата окончания:</label>
                            <input type="date" class="form-control" id="expirationDateInput-e">
                        </div>
                    </form>
                    <div class="w-100"></div>
                    <div class="alert alert-danger fade in" id="editErrorAlert" role="alert"
                         style="display: none">
                        <p id="editErrorAlertText"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn" id="editContractSubmit">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <!-- warning -->
    <div class="modal fade" id="deleteWarning" tabindex="-1" role="dialog" aria-labelledby="deleteWarningLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteWarningLabel">Удаление компании</h5>
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
</div>
</body>
</html>