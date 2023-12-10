<?php include __DIR__ . '/../header.php'; ?>
<h5 class="mb-4">Загрузить новое фото профиля</h5>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<form action="/users/edit/image"
      method="post" enctype="multipart/form-data">
    <input type="file" name="image" class="form-control">

    <div class="d-flex justify-content-end m-2">
        <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Отмена
        </button>
        <input type="submit" class="btn btn-primary" value="Загрузить">
    </div>
</form>
<?php include __DIR__ . '/../footer.php'; ?>

