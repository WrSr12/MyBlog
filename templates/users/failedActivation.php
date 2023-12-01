<?php include __DIR__ . '/../header.php'; ?>
<div class="alert alert-danger text-center" role="alert">
    <h5>Не удалось активировать пользователя &#9785;</h5>
    <?= !empty($error) ? $error : 'Ошибка на стороне сервера' ?>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
