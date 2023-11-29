<?php
include __DIR__ . '/../header.php';
?>
<h2 class="mb-5">Комментарий к статье <span class="fst-italic">'<?= $comment->getArticleName() ?>'</span></h2>
<?php if (!empty($error)): ?>
    <div style="color: red;"><?= $error ?></div>
<?php endif; ?>
<form action="/comments/<?= $comment->getId() ?>/edit"
      method="post">
    <textarea name="text" class="form-control" rows="7"><?= $_POST['text'] ?></textarea>
    <div class="d-flex justify-content-end m-2">
        <a type="button" class="btn btn-secondary me-1 text-white" href="/articles/<?= $comment->getArticleId() ?>#comment<?= $comment->getId() ?>">
            Отмена
        </a>
        <input type="submit" class="btn btn-primary" value="Сохранить изменения">
    </div>
</form>
<?php include __DIR__ . '/../footer.php'; ?>
