<?php
/**
 * @var \MyProject\Models\Users\User $user
 * @var \MyProject\Models\Articles\Article[] $articles
 */
include __DIR__ . '/../header.php';
?>
<?php if ($user->isAdmin()): ?>
    <h5 class="mb-3">Редактировать статью:</h5>
    <?php foreach ($articles as $article): ?>
        <div class="card mb-2">
            <div class="card-body">
                <h6 class="card-title"><?= $article->getName() ?></h6>
                <p class="mb-2">
                    <span class="fst-italic fw-light">Автор: </span><span
                            class="fw-bolder text-primary me-4"><?= $article->getAuthor()->getNickname() ?></span>
                    <span class="fst-italic fw-light">Дата публикации: </span><span
                            class="fw-light my-comment-date me-1"><?= $article->getCreatedAt() ?></span>
                </p>
                <p class="card-text"><?= $article->getShortText() ?></p>
                <a href="/articles/<?= $article->getId() ?>/edit" class="btn btn-primary btn-sm text-white">Редактировать</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-danger text-center" role="alert">
        <h5>Доступ только для администратора</h5>
    </div>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>