<?php
/**
 * @var \MyProject\Models\Users\User $user
 */

include __DIR__ . '/../header.php';
?>
    <h5 class="mb-3">Настройки аккаунта</h5>
    <div class="d-flex mb-3">
        <img src="<?= $user->getImage() ?>" class="rounded me-1" style="height: 200px;">
        <div class="d-block ms-2">
            <span class="fst-italic fw-light">Никнейм: </span><?= $user->getNickname() ?>
            <br>
            <span class="fst-italic fw-light">Email: </span><?= $user->getEmail() ?>
            <br>
            <span class="fst-italic fw-light">Дата регистрации: </span><?= $user->getCreatedAt() ?>
        </div>
    </div>
    <div>
        <!-- Кнопка-триггер модального окна "Загрузить новое изображение профиля"-->
        <button type="button"
                class="btn btn-dark mb-1"
                data-bs-toggle="modal"
                data-bs-target="#uploadImage">
            Загрузить новое изображение профиля
        </button>
        <br>
        <!-- Кнопка-триггер модального окна "Изменить никнейм"-->
        <button type="button"
                class="btn btn-dark mb-1"
                data-bs-toggle="modal"
                data-bs-target="#editNickname">
            Изменить никнейм
        </button>
        <br>
        <a href="/users/comments" class="btn btn-dark text-white mb-1">
            Мои комментарии
        </a>
        <br>
    </div>

    <!-- Модальное окно "Загрузить новое изображение профиля"-->
    <div class="modal fade" id="uploadImage" tabindex="-1"
         aria-labelledby="uploadImage"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="/users/edit/image"
                          method="post" enctype="multipart/form-data">
                        <input type="file" name="image" class="form-control">

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
<?php include __DIR__ . '/../footer.php'; ?>