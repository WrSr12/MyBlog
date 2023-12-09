<?php include __DIR__ . '/../header.php'; ?>
    <h5 class="mb-3">Настройки аккаунта</h5>
    <div>
        <!-- Кнопка-триггер модального окна "Изменить никнейм"-->
        <button type="button"
                class="btn btn-dark mb-1"
                data-bs-toggle="modal"
                data-bs-target="#editNickname">
            Изменить никнейм
        </button>
        <br>
        <!-- Кнопка-триггер модального окна "Добавить фото профиля"-->
        <button type="button"
                class="btn btn-dark mb-1"
                data-bs-toggle="modal"
                data-bs-target="#addPhoto">
            Добавить фото профиля
        </button>
        <br>
        <a href="/users/comments" class="btn btn-dark text-white mb-1">
            Мои комментарии
        </a>
        <br>
    </div>

    <!-- Модальное окно "Изменить никнейм"-->
    <div class="modal fade" id="editNickname" tabindex="-1"
         aria-labelledby="editNickname"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="/users/edit/nickname"
                          method="post">
                        <div>Новый никнейм:</div>
                        <input type="text" name="nickname" class="form-control">

                        <div class="d-flex justify-content-end m-2">
                            <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Отмена
                            </button>
                            <input type="submit" class="btn btn-primary" value="Изменить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно "Добавить фото профиля"-->
    <div class="modal fade" id="addPhoto" tabindex="-1"
         aria-labelledby="addPhoto"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="/users/edit/nickname"
                          method="post">
                        <input type="file" name="photo" class="form-control">

                        <div class="d-flex justify-content-end m-2">
                            <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Отмена
                            </button>
                            <input type="submit" class="btn btn-primary" value="Загрузить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>