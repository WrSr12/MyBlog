<?php
/**
 * @var \MyProject\Models\Articles\Article $article
 * @var \MyProject\Models\Users\User $user
 */

include __DIR__ . '/../header.php';
?>
<h4><?= $article->getName() ?></h4>
<div class="mb-3">
    <span class="fst-italic fw-light">Автор: </span><span
            class="fw-bolder text-primary me-4"><?= $article->getAuthor()->getNickname() ?></span>
    <span class="fst-italic fw-light">Дата публикации: </span><span
            class="fw-light my-comment-date me-1"><?= $article->getCreatedAt() ?></span>
</div>
<div class="mb-3"><?= $article->getText() ?></div>

<?php if ($user !== null && $user->isAdmin()): ?>
    <div>
        <a href="/articles/<?= $article->getId() ?>/edit"
           type="button"
           class="btn btn-outline-primary buttonLinkEdit"
           style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .75rem;">
            Редактировать статью
        </a>
        <!-- Кнопка-триггер модального окна "Удалить статью"-->
        <button type="button" class="btn btn-outline-danger"
                style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .75rem;"
                data-bs-toggle="modal" data-bs-target="#deleteArticle">
            Удалить статью
        </button>
    </div>

    <!-- Модальное окно "Удалить статью"-->
    <div class="modal fade" id="deleteArticle" tabindex="-1"
         aria-labelledby="deleteArticle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="/articles/<?= $article->getId() ?>/delete"
                      method="post">
                    <div class="modal-body">
                        Удалить статью <span class="h6 text-decoration-underline"><?= $article->getName() ?></span>?
                    </div>
                    <div class="d-flex justify-content-end m-2">
                        <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Отмена
                        </button>
                        <input type="submit" class="btn btn-danger" value="Удалить">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<div id="comments" class="commentAmount"><?= $article->getCommentsAmount() ?></div>

<?php if ($user === null): ?>
    <p><a href="/users/login">Авторизуйтесь</a>, чтобы оставить комментарий</p>
<?php else: ?>
    <div class="mb-3">
        <form action="/articles/<?= $article->getId() ?>/comments" method="post">
            <textarea name="text"
                      id="addCommentText"
                      class="addCommentText"
                      rows="1"
                      placeholder="Введите комментарий"><?= $_POST['text'] ?? '' ?></textarea>
            <div class="d-flex justify-content-end">
                <input type="reset" value="Отмена" class="btn btn-secondary me-1"
                       style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .9rem;">
                <input type="submit" value="Оставить комментарий" class="btn btn-success"
                       style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: 1rem;">
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
if (!is_null($article->getComments())): ?>
    <ul class="commentsList">
        <?php foreach ($article->getComments() as $comment): ?>
            <li class="mb-4" id="comment<?= $comment->getId() ?>">
                <div class="m-0 p-0">
                    <span class="fw-bolder text-primary"><?= $comment->getAuthorName() ?></span>
                    <span class="fw-light my-comment-date me-1"><?= $comment->getCreatedAt() ?></span>

                    <?php if (!is_null($user) && ($user->getId() === $comment->getAuthorId() || $user->isAdmin())): ?>
                    <!-- Кнопка-триггер модального окна "Редактировать"-->
                    <button type="button" class="btn btn-outline-primary"
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
                     aria-labelledby="edit<?= $comment->getId() ?>"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="/comments/<?= $comment->getId() ?>/edit"
                                      method="post">
                                    <textarea name="text"
                                              class="form-control"
                                              rows="7"><?= $comment->getText() ?></textarea>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button"
                                                class="btn btn-secondary me-1"
                                                data-bs-dismiss="modal">
                                            Отмена
                                        </button>
                                        <input type="submit" class="btn btn-primary" value="Сохранить изменения">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Модальное окно "Удалить"-->
                <div class="modal fade" id="delete<?= $comment->getId() ?>" tabindex="-1"
                     aria-labelledby="delete<?= $comment->getId() ?>"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="/comments/<?= $comment->getId() ?>/delete"
                                      method="post">
                                    <div><?= $comment->getText() ?></div>
                                    <div class="d-flex justify-content-end m-2">
                                        <button type="button"
                                                class="btn btn-secondary me-1"
                                                data-bs-dismiss="modal">
                                            Отмена
                                        </button>
                                        <input type="submit" class="btn btn-danger" value="Удалить комментарий">
                                    </div>
                                </form>
                            </div>
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
