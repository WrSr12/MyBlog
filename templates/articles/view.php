<?php
/**
 * @var \MyProject\Models\Articles\Article $article
 * @var \MyProject\Models\Users\User $user
 */

use MyProject\Models\Comments\Comment;

include __DIR__ . '/../header.php';
?>
<h1><?= $article->getName() ?></h1>
<p>Автор: <i><?= $article->getAuthor()->getNickname() ?></i></p>
<p><?= $article->getText() ?></p>

<?php if ($user !== null && $user->isAdmin()): ?>
    <p><a href="/articles/<?= $article->getId() ?>/edit">Редактировать статью</a></p>
<?php endif; ?>

<p class="my-comment-amount"><?= Comment::getAmountByArticle($article->getId()) ?></p>

<?php if ($user === null): ?>
    <p><a href="/users/login">Авторизуйтесь</a>, чтобы оставить комментарий</p>
<?php else: ?>
    <div class="mb-3">
        <?php if (isset($_GET['error'])): ?>
            <div style="color: red; font-size: 0.9rem">Комментарий не может быть пустым и не может содержать более 300
                символов
            </div>
        <?php endif; ?>
        <form action="/articles/<?= $article->getId() ?>/comments" method="post">
            <input type="text" name="text" id="comment" class="my-comment-input" placeholder="Введите комментарий">
            <div class="d-flex justify-content-end">
                <input type="reset" value="Отмена" class="btn btn-light me-1"
                       style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .9rem;">
                <input type="submit" value="Оставить комментарий" class="btn btn-secondary"
                       style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .9rem;">
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
$comments = Comment::getAllByArticleId($article->getId());
if (!is_null($comments)): ?>
    <ul class="my-comments-list">
        <?php foreach ($comments as $comment): ?>
            <li class="mb-4" id="<?= $comment->getId() ?>">
                <div class="m-0 p-0">
                    <span class="fw-bolder text-primary"><?= $comment->getAuthorName() ?></span>
                    <span class="fw-light my-comment-date me-1"><?= $comment->getCreatedAt() ?></span>

                    <?php if (!is_null($user) && ($user->getId() === $comment->getAuthorId() || $user->isAdmin())): ?>
                    <!-- Кнопка-триггер модального окна "Редактировать"-->
                    <button type="button" class="btn btn-outline-secondary"
                            style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .75rem;"
                            data-bs-toggle="modal" data-bs-target="#edit<?= $comment->getId() ?>">
                        Редактировать
                    </button>
                    <!-- Кнопка-триггер модального окна "Удалить"-->
                    <button type="button" class="btn btn-outline-danger"
                            style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .75rem;"
                            data-bs-toggle="modal" data-bs-target="#delete<?= $comment->getId() ?>">
                        Удалить
                    </button>
                </div>

                <!-- Модальное окно "Редактировать"-->
                <div class="modal fade" id="edit<?= $comment->getId() ?>" tabindex="-1"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="/articles/<?= $article->getId() ?>/comments/<?= $comment->getId() ?>/edit"
                                  method="post">
                                <div class="modal-body">
                                    <textarea name="text" class="form-control"
                                              rows="7"><?= $comment->getText() ?></textarea>
                                </div>
                                <div class="d-flex justify-content-end m-2">
                                    <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Закрыть
                                    </button>
                                    <input type="submit" class="btn btn-primary" value="Сохранить изменения">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Модальное окно "Удалить"-->
                <div class="modal fade" id="delete<?= $comment->getId() ?>" tabindex="-1"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="/articles/<?= $article->getId() ?>/comments/<?= $comment->getId() ?>/delete"
                                  method="post">
                                <div class="modal-body">
                                    <?= $comment->getText() ?>
                                </div>
                                <div class="d-flex justify-content-end m-2">
                                    <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Закрыть
                                    </button>
                                    <input type="submit" class="btn btn-danger" value="Удалить комментарий">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="m-0 p-0"><?= $comment->getText() ?></div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>
