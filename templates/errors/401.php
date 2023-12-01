<?php include __DIR__ . '/../header.php'; ?>
<div class="alert alert-danger text-center" role="alert">
    <h5><?= !empty($error) ? $error : 'Для доступа необходимо авторизоваться' ?></h5>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
