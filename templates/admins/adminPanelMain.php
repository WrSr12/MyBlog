<?php
/**
 * @var \MyProject\Models\Users\User $user
 */
include __DIR__ . '/../header.php';
?>
<?php if ($user->isAdmin()): ?>
    <h5 class="mb-3">Панель администратора</h5>
    <ul class="list-unstyled">
        <li><a href="/articles/add">Добавить статью</a></li>
        <li><a href="/administration/articles">Редактировать статью</a></li>
        <li><a href="/administration/comments">Редактировать комментарий</a></li>
    </ul>
<?php else: ?>
    <div class="alert alert-danger text-center" role="alert">
        <h5>Доступ только для администратора</h5>
    </div>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>