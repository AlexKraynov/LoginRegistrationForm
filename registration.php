<?php
require_once './classes/base.php';
require_once './classes/regtime.php';
require_once './functions/functions.php';

$fields = array();
$errors = array();

if (isset($_POST['btn_submit'])) {
    $time_zone = $_POST['time_zone'];

    $errors['login'] = $errors['email'] = $errors['pass'] = $errors['pass_again'] = $errors['date'] = '';

    $fields['login'] = trim($_POST['login']);
    $fields['email'] = trim($_POST['email']);
    $fields['pass'] = trim($_POST['pass']);
    $fields['ip'] = trim($_SERVER['REMOTE_ADDR']);
    $fields['date'] = date('Y-m-d H:i:s', time());

    $pass_again = trim($_POST['pass_again']);

    $errors['login'] = checkLogin($fields['login']) === true ? '' : checkLogin($fields['login']);
    $errors['email'] = checkEmail($fields['email']) === true ? '' : checkEmail($fields['email']);
    $errors['pass'] = checkPass($fields['pass']) === true ? '' : checkPass($fields['pass']);
    $errors['pass_again'] = checkPassEquality($fields['pass'], $pass_again) === true ? '' : checkPassEquality($fields['pass'], $pass_again);

// Проверка времени  регистрации
    // Получение из базы последней даты регистраци с указанного IP
    $base = new Base();
    $result = $base->selectLastRegIpTime($fields['ip']);
    if ($result) {
        $time = $result[0]['date'];

        // Проверка времени
        $regtime = new Regtime($time);
        $regtime->setInterval(30);
        $errors['date'] = $regtime->checkRegIpTime($time_zone);
    }
//////////////////////////////////////////////////////////////////////    

    if ($errors['login'] === '' && $errors['email'] === '' && $errors['pass'] === '' && $errors['pass_again'] === '' && $errors['date'] === '') {
        $base = new Base();
        $fields['pass'] = md5($fields['pass']);
        $base->save($fields);
        header('location: /LoginRegistrationForm/html/welcome_reg.php');
    }
}
?>

<html>
    <head>
        <title>Регистрация</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="./css/style.css?<?= intval(microtime(1)) ?>" rel="stylesheet" type="text/css" />
    </head>

    <script type="text/javascript" src="./js/jquery-1.7.2.min.js"></script>

    <script>
        $(document).ready(function () {
            var date = new Date();
            var user_time = Date.UTC(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes(), date.getSeconds());
            var time_zone = ((<?php echo time(); ?> - user_time / 1000) / 60 / 60).toFixed(0);
            $('#time_zone').val(time_zone);

            $('#form #login').change(function () {
                $('#form #login_error').text('');
            });
            $('#form #email').change(function () {
                $('#form #email_error').text('');
            });
            $('#form #pass').change(function () {
                $('#form #pass_error').text('');
            });
            $('#form #pass_again').change(function () {
                $('#form #pass_again_error').text('');
            });
        });
    </script>

<!--    <script language="javascript">
        var message = 'Hello, server!';
        $.get('', {message: message}, function (data) {
            alert('Сервер ответил: ' + data);
        });
    </script>-->

    <body>
        <div id="aaaaa" class="instruction"></div>
        <form id="form" action="" method="post">
            <div class="wrap_reg_form">
                <div><h2>Регистрация</h2></div>
                <div class="row">
                    <input type="text" class="text" name ="login" id="login" required placeholder="Логин" value="<?= @$fields['login']; ?>" />
                    <div class="error" id="login_error"><?= @$errors['login']; ?></div>
                </div>
                <div class="row">
                    <input type="email" class="text" name ="email" id="email" required placeholder="Эл. почта" value="<?= @$fields['email']; ?>" />
                    <div class="error" id="email_error"><?= @$errors['email']; ?></div>
                </div>
                <div class="row">
                    <input type="password" class="text" name="pass" id="pass" required placeholder="Пароль" value="<?= @$fields['pass']; ?>" />
                    <div class="error" id="pass_error"><?= @$errors['pass']; ?></div>
                    <div class="instruction" id="pass_instruction">
                        Пароль должен быть не короче 6 символов
                        <br>
                        и не длиннее 16 символов
                    </div>
                </div>
                <div class="row">
                    <input type="password" class="text" name="pass_again" id="pass_again" required placeholder="Повтор пароля" value="<?= @$fields['pass_again']; ?>" />
                    <div class="error" id="pass_again_error"><?= @$errors['pass_again']; ?></div>
                    <div class="instruction" id="pass_again_instruction">
                        Повторите введенный пароль
                    </div>
                </div>
                <div class="row">
                    <div class="error" id="date_error"><?= @$errors['date']; ?></div>
                </div>
                <input type="hidden" id="time_zone" name="time_zone">
                <div class="row">
                    <input type="submit" name="btn_submit" id="btn_submit" value="Зарегистрироваться" />
                    <input type="button" name="btn_cancel" id="btn_cancel" value="Отмена" onclick='location.href = "/LoginRegistrationForm"'/>
                </div>
            </div>
        </form>
    </body>
</html>



