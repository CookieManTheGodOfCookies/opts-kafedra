<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="scripts/jquery-3.3.1.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheets/MainStyle.css">
    <title>Авторизация</title>
</head>
<body>

<div class="auth-form">
    <form id="auth-form" method="post">
        <label>
            <span class="auth-form-input">Username:</span> <input type="text" class="auth-form-input"
                                                                  name="username">
        </label>
        <br>
        <label>
            <span class="auth-form-input">Password:</span> <input type="password" class="auth-form-input"
                                                                  name="password">
        </label>
        <br>
        <label>
            <input type="button" id="auth-submit" class="auth-submit" value="submit">
        </label>
    </form>
</div>
<script src="scripts/Authorisation.js"></script>
</body>
</html>