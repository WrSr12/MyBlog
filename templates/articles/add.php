<?php
/**
 * @var \MyProject\Models\Users\User $user
 */

include __DIR__ . '/../header.php';
?>
<?php if ($user->isAdmin()): ?>
    <h5 class="mb-4">Создание новой статьи</h5>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <form action="/articles/add" method="post">
        <label for="name">Название статьи</label>
        <input type="text"
               name="name"
               id="name"
               value="<?= $_POST['name'] ?? '' ?>"
               size="50"
               class="form-control mb-2">

        <label for="text">Текст статьи</label>
        <textarea name="text"
                  id="text"
                  rows="10"
                  cols="80"
                  class="form-control mb-2"><?= $_POST['text'] ?? '' ?></textarea>

        <div class="d-flex justify-content-end">
            <a type="button" class="btn btn-secondary me-1 text-white"
               href="/administration">
                Отмена
            </a>
            <input type="submit" class="btn btn-success" value="Создать">
        </div>
    </form>
<?php else: ?>
    <div class="alert alert-danger text-center" role="alert">
        <h5>Доступ только для администратора</h5>
    </div>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>
