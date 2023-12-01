<?php include __DIR__ . '/../header.php'; ?>
    <h2 class="mb-3">Редактировать комментарий:</h2>
<?php foreach ($comments as $comment): ?>
    <div class="card mb-2">
        <div class="card-body">
            <div class="card-title">
                <p class="d-inline me-3">
                    <span class="fw-light">Автор:</span> <?= $comment->getAuthorName() ?>
                </p>
                <p class="d-inline">
                    <span class="fw-light">Статья:</span> <?= $comment->getArticleName() ?>
                </p>
                <p class="fw-light"><?= $comment->getCreatedAt() ?></p>
            </div>
            <p class="card-text"><?= $comment->getText() ?></p>
            <a href="/comments/<?= $comment->getId() ?>/edit" class="btn btn-primary text-white">Редактировать</a>
        </div>
    </div>
<?php endforeach; ?>
<?php include __DIR__ . '/../footer.php'; ?>