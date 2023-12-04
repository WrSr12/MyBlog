<?php
/**
 * @var \MyProject\Models\Users\User $user
 */
include __DIR__ . '/../header.php';
?>
<?php if ($user->isAdmin()): ?>
    <h1>Создание новой статьи</h1>
    <?php if (!empty($error)): ?>
        <div style="color: red;"><?= $error ?></div>
    <?php endif; ?>
    <form action="/articles/add" method="post">
        <label for="name">Название статьи</label><br>
        <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>" size="50"><br>
        <br>
        <label for="text">Текст статьи</label><br>
        <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? '' ?></textarea><br>
        <br>
        <input type="submit" value="Создать">
    </form>
<?php else: ?>
    <div class="alert alert-danger text-center" role="alert">
        <h5>Доступ только для администратора</h5>
    </div>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>
