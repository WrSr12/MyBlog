<?php include __DIR__ . '/../header.php'; ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= !empty($error) ? $error : 'Страница не найдена' ?>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>