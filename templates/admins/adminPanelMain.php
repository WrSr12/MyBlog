<?php include __DIR__ . '/../header.php'; ?>
<h2 class="mb-3">Добро пожаловать в панель администратора, <span class="fst-italic"><?= $user->getNickname() ?></span></h2>
    <ul>
        <li><a href="/administration/articles">Редактировать статью</a></li>
        <li><a href="/administration/comments">Редактировать комментарий</a></li>
    </ul>
<?php include __DIR__ . '/../footer.php'; ?>