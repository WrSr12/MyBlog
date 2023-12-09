<?php
/**
 * @var \MyProject\Models\Articles\Article $article
 */

include __DIR__ . '/../header.php';
?>
<h5 class="mb-4">Комментарий к статье <a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a>
</h5>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<form action="/articles/<?= $article->getId() ?>/comments" method="post">
    <textarea name="text"
              class="form-control mb-2"
              rows="9"><?= $_POST['text'] ?? '' ?></textarea>
    <div class="d-flex justify-content-end">
        <a type="button"
           class="btn btn-secondary me-1 text-white"
           href="/articles/<?= $article->getId() ?>#commentAmount">
            Отмена
        </a>
        <input type="submit" class="btn btn-success" value="Оставить комментарий">
    </div>
</form>
<?php include __DIR__ . '/../footer.php'; ?>

