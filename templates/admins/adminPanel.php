<?php include __DIR__ . '/../header.php'; ?>
    <h5 class="mb-3">Панель администратора</h5>
    <div>
        <a href="/articles/add" class="btn btn-dark text-white mb-1" role="button">
            Добавить статью
        </a>
        <br>
        <a href="/administration/articles" class="btn btn-dark text-white mb-1">
            Управление статьями
        </a>
        <br>
        <a href="/administration/comments" class="btn btn-dark text-white mb-1">
            Управление комментариями
        </a>
        <br>
        <!-- Кнопка-триггер модального окна "Поменять название сайта"-->
        <button type="button" class="btn btn-dark"
                data-bs-toggle="modal" data-bs-target="#deleteArticle">
            Изменить название сайта
        </button>
    </div>

    <!-- Модальное окно "Поменять название сайта"-->
    <div class="modal fade" id="deleteArticle" tabindex="-1"
         aria-labelledby="deleteArticle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="/administration/site/name"
                      method="post">
                    <div class="modal-body">
                        <div>Новое название:</div>
                        <input type="text" name="siteName" class="form-control">
                    </div>
                    <div class="d-flex justify-content-end m-2">
                        <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Отмена
                        </button>
                        <input type="submit" class="btn btn-primary" value="Изменить">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>