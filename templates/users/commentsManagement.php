<?php
/**
 * @var \MyProject\Models\Comments\Comment[] $comments
 */
include __DIR__ . '/../header.php';
?>
    <h5 class="mb-3">Управление комментариями</h5>

<?php if (!is_null($comments)): ?>
    <?php foreach ($comments as $comment): ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-title">
                    <div>
                        <span class="fst-italic fw-light">Дата публикации: </span><span
                                class="fw-light my-comment-date"><?= $comment->getCreatedAt() ?></span>
                    </div>
                    <div>
                        <span class="fst-italic fw-light">Комментарий к статье:</span> <a
                                href="/articles/<?= $comment->getArticleId() ?>"><?= $comment->getArticleName() ?></a>
                    </div>
                </div>

                <div class="card-text">
                    <div class="mb-3"><?= $comment->getShortText(200) ?></div>
                    <div>
                        <!-- Кнопка-триггер модального окна "Редактировать"-->
                        <button type="button" class="btn btn-primary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#edit<?= $comment->getId() ?>">
                            Редактировать
                        </button>

                        <!-- Кнопка-триггер модального окна "Удалить"-->
                        <button type="button" class="btn btn-danger btn-sm"
                                data-bs-toggle="modal" data-bs-target="#delete<?= $comment->getId() ?>">
                            Удалить
                        </button>
                    </div>
                </div>
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
                                    <textarea name="editCommentText"
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
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-success text-center" role="alert">
        Комментариев пока нет
    </div>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>