<?php include __DIR__ . '/../header.php'; ?>
    <div class="alert alert-danger text-center" role="alert">
        <h5><?= !empty($error) ? $error : 'Страница не найдена' ?></h5>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>