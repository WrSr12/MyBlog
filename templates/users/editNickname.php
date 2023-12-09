<?php include __DIR__ . '/../header.php'; ?>
<h5 class="mb-4">Изменить никнейм</h5>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<form action="/users/edit/nickname"
      method="post">
    <input name="nickname"
           class="form-control mb-2"
           value="<?= $_POST['nickname'] ?? '' ?>"
           placeholder="Введите новый никнейм">
    <div class="d-flex justify-content-end">
        <a type="button"
           class="btn btn-secondary me-1 text-white"
           href="/users/account">
            Отмена
        </a>
        <input type="submit" class="btn btn-primary" value="Сохранить изменения">
    </div>
</form>
<?php include __DIR__ . '/../footer.php'; ?>
