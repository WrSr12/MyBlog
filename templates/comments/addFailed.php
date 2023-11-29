<?php
include __DIR__ . '/../header.php';
?>
<h2 class="mb-5">Комментарий к статье <span class="fst-italic">'<?= $article->getName() ?>'</span></h2>
<?php if (!empty($error)): ?>
    <div style="color: red;" class="mb-3"><?= $error ?></div>
<?php endif; ?>
<form action="/articles/<?= $article->getId() ?>/comments" method="post">
    <textarea name="text" class="form-control" rows="7"><?= $_POST['text'] ?></textarea>
    <div class="d-flex justify-content-end">
        <a type="button" class="btn btn-light me-1" href="/articles/<?= $article->getId() ?>#comment-amount">
            Отмена
        </a>
        <input type="submit" value="Оставить комментарий" class="btn btn-secondary"
               style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: 1rem;">
    </div>
</form>
<?php include __DIR__ . '/../footer.php'; ?>
