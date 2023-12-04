<?php
/**
 * @var \MyProject\Models\Users\User $user
 * @var \MyProject\Models\Comments\Comment[] $comments
 */
include __DIR__ . '/../header.php';
?>
<?php if ($user->isAdmin()): ?>
    <h5 style="" class="mb-3">Редактировать комментарий:</h5>
    <?php foreach ($comments as $comment): ?>
        <div class="card mb-2">
            <div class="card-body">
                <div class="card-title">
                    <p class="mb-2">
                        <span class="fst-italic fw-light">Автор: </span><span
                                class="fw-bolder text-primary me-4"><?= $comment->getAuthorName() ?></span>
                        <span class="fst-italic fw-light">Дата публикации: </span><span
                                class="fw-light my-comment-date me-1"><?= $comment->getCreatedAt() ?></span>
                    </p>
                    <p class="d-inline">
                        <span class="fst-italic fw-light">Статья:</span> <a
                                href="/articles/<?= $comment->getArticleId() ?>"><?= $comment->getArticleName() ?></a>
                    </p>
                </div>
                <p class="card-text"><?= $comment->getText() ?></p>
                <a href="/comments/<?= $comment->getId() ?>/edit" class="btn btn-primary btn-sm text-white">Редактировать</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-danger text-center" role="alert">
        <h5>Доступ только для администратора</h5>
    </div>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>