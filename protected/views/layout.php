<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--<link href='https://fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic-ext'
              rel='stylesheet' type='text/css'> -->
        <link rel="stylesheet" href="/styles/flex.css" type="text/css">
        <script src="/js/getXmlHttpRequest.js"></script>
        <title>Доска объявлений</title>
    </head>
    <body>
    <?php if(!empty($_SESSION['error_msg'])) : ?>
        <div class="error-msg" onclick="hideError()">
            <?php
                echo $_SESSION['error_msg'];
                unset($_SESSION['error_msg']);
            ?>
        </div>
    <?php endif; ?>
        <div class="dark-layout" onclick="closeAuthForm()"></div>
        <div class="popup-form">
            <form action="/user/login" method="POST" class="advert-form">
                <div class="form-auth-group">
                    <label for="login" class="label">Логин: </label>
                    <input type="text" class="auth-input" name="login" id="login" required>
                </div>
                <div class="form-auth-group">
                    <label for="password" class="label">Пароль: </label>
                    <input type="password" class="auth-input" name="password" id="password" required>
                </div>
                <input type="submit" value="Войти" class="advert-form-submit">
            </form>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT']."/protected/views/header.php"; ?>
        <div class="main-content-block container">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].
                "/protected/views/side_menu.php"; ?>
            <div class="items-block">
                <?php
                    include(dirname(__FILE__).'/'. $file);
                ?>
            </div>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].
            "/protected/views/footer.php"; ?>
    </body>
</html>