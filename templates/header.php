<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/style.css">
    <title>Мой блог</title>
</head>
<body>

<table class="layout">
    <tr>
        <td class="header">
            Мой блог
        </td>
        <td class="headerAuthorization">
            <?php if (!empty($user)): ?>
                Привет, <?= $user->getNickname() ?> | <a href="/users/logout">Выйти</a>
            <?php else: ?>
                <a href="/users/login">Войти</a> | <a href="/users/register">Зарегистрироваться</a>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>
