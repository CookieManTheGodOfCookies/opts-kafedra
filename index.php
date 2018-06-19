<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- JQuery -->
    <script src="scripts/jquery-3.3.1.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="stylesheets/custom_styles.css">
    <title>Авторизация</title>
</head>
<body>


<div class="container">
    <div class="row ">
        <div class="col-lg-4 col-md-4 col-sm-4"></div>
        <div class="col-lg-4 col-md-4 col-sm-4" style="margin-top: 130px;">

            <div class="col-sm-12 col-md-12 col-xs-12 auth-form-container">
                <form id="auth-form" method="post">
                    <div class="form-group">
                        <label for="usernameInput">Username</label>
                        <input type="text" class="form-control" id="usernameInput" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="passwordInput">Password</label>
                        <input type="password" class="form-control" id="passwordInput" name="password" required>
                    </div>
                    <input type="button" id="auth-submit" class="btn mb-2 auth-submit-button" value="submit">
                </form>
            </div>
            <div class="w-100"></div>
            <div class="alert alert-danger fade in col-sm-12 col-md-12" id="dangerAlert" role="alert"
                 style="display: none;">Неверные данные!
            </div>
        </div>
    </div>

</div>
<script src="scripts/Authorisation.js"></script>
</body>
</html>