<html>
    <head>
        <title>Форма регистрации/входа пользователей</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="./css/style.css?<?= intval(microtime(1)) ?>" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="container">
            <div id="title"><h1>Регистрация/Вход</h1></div>
            <div id="buttons">
                <input type="button" value="Регистрация" onclick="location.href = '/LoginRegistrationForm/registration.php'">
                <input type="button" value="Вход" onclick="location.href = '/LoginRegistrationForm/login.php'">
            </div>
        </div>
    </body>
</html>