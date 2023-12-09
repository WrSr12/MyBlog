<?php
/**
 * @var \MyProject\Models\Articles\Article[] $articles
 */
include __DIR__ . '/../header.php';
?>
    <h5 class="mb-3">Управление статьями</h5>
<?php if (!is_null($articles)): ?>
    <?php foreach ($articles as $article): ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-title">
                    <h6><?= $article->getName() ?></h6>
                    <div>
                        <span class="fst-italic fw-light">Автор: </span><span
                                class="fw-bolder text-primary me-4"><?= $article->getAuthor()->getNickname() ?></span>
                        <span class="fst-italic fw-light">Дата публикации: </span><span
                                class="fw-light my-comment-date"><?= $article->getCreatedAt() ?></span>
                    </div>
                </div>

                <div class="card-text">
                    <div class="mb-3"><?= $article->getShortText(150) ?></div>

                    <div>
                        <a href="/articles/<?= $article->getId() ?>/edit" class="btn btn-primary btn-sm text-white">Редактировать</a>

                        <!-- Кнопка-триггер модального окна "Удалить статью"-->
                        <button type="button" class="btn btn-danger btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteArticle">
                            Удалить
                        </button>
                    </div>
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
                                    Удалить статью <span
                                            class="h6 text-decoration-underline"><?= $article->getName() ?></span>?
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
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-success text-center" role="alert">
        Статей пока нет
    </div>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>