<?php

require_once './classes/base.php';

function checkLogin($login) {
    $error = '';

    if (!$login) {
        $error = 'Вы не ввели имя пользователя';
        return $error;
    }

    $base = new Base();
    $field = 'login';
    $result = $base->select($field, $login);

    if (!empty($result)) {
        $error = 'Пользователь с указанным логином уже зарегистрирован в системе';
        return $error;
    }
    return true;
}

function checkPass($pass) {
    $error = '';

    if (!$pass) {
        $error = 'Вы не ввели пароль';
        return $error;
    }

    $pattern = '/^[_!)(.a-z\d]{6,16}$/i';
    $result = preg_match($pattern, $pass);
    if (!$result) {
        $error = 'Недопустимые символы в пароле пользователя или пароль слишком короткий (длинный)';
        unset($result);
        return $error;
    }

    return true;
}

function checkPassEquality($pass, $pass_again) {
    $error = '';

    if (!$pass_again) {
        $error = 'Вы не ввели пароль';
        return $error;
    }

    if ($pass != $pass_again) {
        $error = 'Введенные пароли не совпадают';
        return $error;
    }

    return true;
}

function checkEmail($email) {
    $error = '';

    if (!$email) {
        $error = 'Вы не ввели адрес эл. почты';
        return $error;
    }

    if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
        $error = 'Введите корректный адрес эл. почты';
        return $error;
    }

    $base = new Base();
    $field = 'email';
    $result = $base->select($field, $email);

    if (!empty($result)) {
        $error = 'Пользователь с указанным адресом эл. почты уже зарегистрирован в системе';
        return $error;
    }
    return true;
}
