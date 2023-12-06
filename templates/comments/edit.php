<?php
/**
 * @var \MyProject\Models\Comments\Comment $comment
 */

include __DIR__ . '/../header.php';
?>
<h5 class="mb-4">Комментарий к статье <a
            href="/articles/<?= $comment->getArticleId() ?>"><?= $comment->getArticleName() ?></a>
</h5>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<form action="/comments/<?= $comment->getId() ?>/edit"
      method="post">
    <textarea name="editCommentText"
              class="form-control mb-2"
              rows="8"><?= !empty($_POST['editCommentText']) ? $_POST['editCommentText'] : $comment->getText() ?></textarea>
    <div class="d-flex justify-content-end">
        <a type="button"
           class="btn btn-secondary me-1 text-white"
           href="/articles/<?= $comment->getArticleId() ?>#comment<?= $comment->getId() ?>">
            Отмена
        </a>
        <input type="submit" class="btn btn-primary" value="Сохранить изменения">
    </div>
</form>
<?php include __DIR__ . '/../footer.php'; ?>
