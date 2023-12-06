<?php
/**
 * @var \MyProject\Models\Comments\Comment[] $comments
 */
include __DIR__ . '/../header.php';
?>
    <h5 style="" class="mb-3">Управление комментариями</h5>
<?php foreach ($comments as $comment): ?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">
                <div>
                    <span class="fst-italic fw-light">Автор: </span><span
                            class="fw-bolder text-primary me-4"><?= $comment->getAuthorName() ?></span>
                    <span class="fst-italic fw-light">Дата публикации: </span><span
                            class="fw-light my-comment-date"><?= $comment->getCreatedAt() ?></span>
                </div>
                <div>
                    <span class="fst-italic fw-light">Комментарий к статье:</span> <a
                            href="/articles/<?= $comment->getArticleId() ?>"><?= $comment->getArticleName() ?></a>
                </div>
            </div>

            <div class="card-text">
                <div class="mb-3"><?= $comment->getShortText(150) ?></div>
                <div>
                    <a href="/comments/<?= $comment->getId() ?>/edit" class="btn btn-primary btn-sm text-white">Редактировать</a>

                    <!-- Кнопка-триггер модального окна "Удалить"-->
                    <button type="button" class="btn btn-danger btn-sm"
                            data-bs-toggle="modal" data-bs-target="#delete<?= $comment->getId() ?>">
                        Удалить
                    </button>
                </div>
            </div>

            <!-- Модальное окно "Удалить"-->
            <div class="modal fade" id="delete<?= $comment->getId() ?>" tabindex="-1"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="/comments/<?= $comment->getId() ?>/delete"
                              method="post">
                            <div class="modal-body">
                                <?= $comment->getText() ?>
                            </div>
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
<?php include __DIR__ . '/../footer.php'; ?>