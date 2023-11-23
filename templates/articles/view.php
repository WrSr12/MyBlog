<?php
/**
 * @var \MyProject\Models\Articles\Article $article
 * @var \MyProject\Models\Users\User $user
 */
include __DIR__ . '/../header.php';
?>
<h1><?= $article->getName() ?></h1>
<p>Автор: <i><?= $article->getAuthor()->getNickname() ?></i></p>
<p><?= $article->getText() ?></p>
<?php if ($user !== null && $user->isAdmin()): ?>
    <p><a href="/articles/<?= $article->getId() ?>/edit">Редактировать статью</a></p>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>
