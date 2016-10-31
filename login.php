<?php
require_once './classes/base.php';
require_once './classes/regtime.php';
require_once './functions/functions.php';

$fields = array();
$errors = array();

if (isset($_POST['btn_submit'])) {
    $errors['login'] = $errors['pass'] = '';

    $fields['login'] = trim($_POST['login']);
    $fields['pass'] = trim($_POST['pass']);

    $base = new Base();
    $field = 'login';
    $result = $base->select($field, $fields['login']);

    if (!$result) {
        $errors['login'] = 'Пользователь с указанным логином не зарегистрирован в системе';
    } else {
        if ($result['password'] != md5($fields['pass'])) {
            $errors['pass'] = 'Указан неверный пароль';
        }
    }

    if ($errors['login'] === '' && $errors['pass'] === '') {
        header('location: /LoginRegistrationForm/html/welcome_log.php');
    }
}
?>

<html>
    <head>
        <title>Вход</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="./css/style.css?<?= intval(microtime(1)) ?>" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <form id="form" action="" method="post">
            <div class="wrap_reg_form">
                <div><h2>Вход</h2></div>
                <div class="row">
                    <input type="text" class="text" name ="login" id="login" required placeholder="Логин" value="<?= @$fields['login']; ?>" />
                    <div class="error" id="login_error"><?= @$errors['login']; ?></div>
                </div>
                <div class="row">
                    <input type="password" class="text" name="pass" id="pass" required placeholder="Пароль" value="<?= @$fields['pass']; ?>" />
                    <div class="error" id="pass_error"><?= @$errors['pass']; ?></div>
                </div>
                <div class="row">
                    <input type="submit" name="btn_submit" id="btn_submit" value="Войти" />
                    <input type="button" name="btn_cancel" id="btn_cancel" value="Отмена" onclick='location.href = "/LoginRegistrationForm"'/>
                </div>
            </div>
        </form>
    </body>
</html>


