<?php
require_once './classes/base.php';
require_once './functions/functions.php';

$fields = array();
$errors = array();

$base = new Base();
$ip = '11111';
$result = $base->selectLastRegIpTime($ip);
echo date_default_timezone_get() . '<br>';
echo $result[0]['date'] . '<br>';
$str = '2012-09-16 7:30:00';
$str = $result[0]['date'];
echo date('Y-m-d H:i:s', strtotime("$str - 0 hours - 15 minutes - 0 seconds")) . '<br>';
echo 'time() - ' . date('Y-m-d H:i:s', time()) . '<br>';
echo 'date() -' . date('Y-m-d H:i:s');
//echo time() . '<br>';
//echo ((time() - strtotime($result[0]['date']))/1). '<br>';
//'<pre>' . print_r($result) . '</pre><br>';

if (isset($_POST['btn_submit'])) {
    $errors['login'] = $errors['email'] = $errors['ip'] = '';

    $fields['login'] = trim($_POST['login']);
    $fields['email'] = trim($_POST['email']);
    $fields['pass'] = trim($_POST['pass']);
//    $fields['ip'] = trim($_SERVER['REMOTE_ADDR']);
    $fields['ip'] = trim('11111');

    $pass_again = trim($_POST['pass_again']);

    $errors['login'] = checkLogin($fields['login']) === true ? '' : checkLogin($fields['login']);
    $errors['email'] = checkEmail($fields['email']) === true ? '' : checkEmail($fields['email']);
    $errors['pass'] = checkPass($fields['pass']) === true ? '' : checkPass($fields['pass']);
    $errors['pass_again'] = checkPassEquality($fields['pass'], $pass_again) === true ? '' : checkPassEquality($fields['pass'], $pass_again);

    if ($errors['login'] === '' && $errors['email'] === '' && $errors['pass'] === '' && $errors['pass_again'] === '') {
        $base = new Base();
        $base->save($fields);
        header('location: /LoginRegistrationForm/html/welcome.php');
    } else {
        
    }
}
?>

<html>
    <head>
        <title>Регистрация</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="./css/style.css?<?= intval(microtime(1)) ?>" rel="stylesheet" type="text/css" />
    </head>

    <script type="text/javascript"
            src="./js/jquery-1.7.2.min.js">
    </script>

    <script>
        $(document).ready(function () {
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

    <body>
        <form id="form" action="" method="post">
            <div class="wrap_reg_form">
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
                    <input type="submit" name="btn_submit" id="btn_submit" value="Зарегистрироваться" />
                    <input type="button" name="btn_cancel" id="btn_cancel" value="Отмена" onclick='location.href = "/LoginRegistrationForm"'/>
                </div>
            </div>
        </form>
    </body>
</html>


