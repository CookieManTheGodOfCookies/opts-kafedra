<!DOCTYPE html>
<?php
session_start();
include_once ('utils/test_input.php');
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Компании</title>
    <!-- JQuery -->
    <script src="scripts/jquery-3.3.1.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="stylesheets/custom_styles.css">

    <script src="scripts/adders/AddCompanyModal.js"></script>
    <script src="scripts/editors/EditCompanyModal.js"></script>


</head>
<body>
<!-- NAV -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
    <div class="navbar-header">
        <div class="navbar-brand">OPTS</div>
    </div>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="StudentList.php">Студенты</a>
        </li>
        <?php
        if ($_SESSION['role'] == 'OPTS') {
            ?>
            <li class="nav-item active">
                <a class="nav-link" href="CompaniesList.php">Компании</a>
            </li>
            <?php
        }
        ?>
    </ul>
    <ul class="navbar-nav navbar-right nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Выход</a>
        </li>
    </ul>
</nav>


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

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Компании</li>
    </ol>
</nav>

<button type="button" id="add-company" class="btn addCompany">Добавить</button>

<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Название</th>
        <th>Контактная информация</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i = 0; $i < $table->num_rows; $i++) {
        $row = $table->fetch_assoc();
        $cid = $row["compID"];
        ?>
        <tr>
            <td><?php echo $row['compName'] ?></td>
            <td><?php echo $row['contactInfo'] ?></td>
            <td>
                <button type="button" class="btn btn-secondary"
                        onclick="window.location.href='CompanyView.php?id=<?= $cid ?>'">Подробнее
                </button>
            </td>
            <td>
                <button type="button" id="<?= $cid ?>" class="edit-company btn btn-secondary">Редактировать</button>
            </td>
        </tr>
    <?php }
    ?>
    </tbody>
</table>

<!-- Add Company Modal -->

<div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCompanyModalLabel">Добавить компанию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="addCompanyForm">
                    <div class="form-group">
                        <label for="companyNameInput-a" class="col-form-label">Название:</label>
                        <input type="text" class="form-control" id="companyNameInput-a">
                    </div>
                    <div class="form-group">
                        <label for="contactInfoInput-a" class="col-form-label">Контактная информация:</label>
                        <textarea class="form-control" id="contactInfoInput-a"></textarea>
                    </div>
                </form>
            </div>
            <div class="w-100"></div>
            <div class="alert alert-danger show col-sm-12 col-md-12" id="addErrorAlert" role="alert" style="display: none">
                <p id="addErrorAlertText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn" id="add-company-submit">Добавить</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Company Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="editCompanyModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyModalLabel">Редактировать компанию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCompanyForm">
                    <div class="form-group">
                        <label for="companyNameInput-e" class="form-col-label">Название:</label>
                        <input type="text" class="form-control" id="companyNameInput-e">
                    </div>
                    <div class="form-group">
                        <label for="contactInfoInput-e" class="form-col-label">Контактная информация:</label>
                        <textarea class="form-control" id="contactInfoInput-e"></textarea>
                    </div>
                </form>
            </div>
            <div class="w-100"></div>
            <div class="alert alert-danger show col-sm-12 col-md-12" id="editErrorAlert" role="alert" style="display: none">
                <p id="editErrorAlertText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn" id="edit-company-submit">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>