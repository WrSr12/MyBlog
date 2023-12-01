<?php include __DIR__ . '/../header.php'; ?>
<h2 class="mb-3">Редактировать статью:</h2>
<?php foreach ($articles as $article): ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title"><?= $article->getName() ?></h5>
            <p class="fw-light"><?= $article->getCreatedAt() ?></p>
            <p class="card-text"><?= $article->getShortText() ?></p>
            <a href="/articles/<?= $article->getId() ?>/edit" class="btn btn-primary text-white">Редактировать</a>
        </div>
    </div>
<?php endforeach; ?>
<?php include __DIR__ . '/../footer.php'; ?>