<?php
/**
 * @var \MyProject\Models\Articles\Article[] $articles
 */

include __DIR__ . '/../header.php';
?>
<?php foreach ($articles as $article): ?>
    <h5><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h5>
    <p><?= $article->getShortText(500) ?></p>
    <hr>
<?php endforeach; ?>
<?php include __DIR__ . '/../footer.php'; ?>