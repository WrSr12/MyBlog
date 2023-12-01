<?php include __DIR__ . '/../header.php'; ?>
    <div style="text-align: center;">
        <h1 class="mb-4">Вход</h1>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <form action="/users/login" method="post">
            <table class="formAuthorization">
                <tr>
                    <td class="text-end align-middle"><label for="email">Email</label></td>
                    <td><input type="email"
                               name="email"
                               value="<?= $_POST['email'] ?? '' ?>"
                               id="email"
                               class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="pb-3 text-end align-middle"><label for="password">Пароль</label></td>
                    <td class="pb-3"><input type="password"
                                            name="password"
                                            value="<?= $_POST['password'] ?? '' ?>"
                                            id="password"
                                            class="form-control">
                    </td>
                </tr>
                <tr class="mt-3">
                    <td colspan="2">
                        <input type="submit" class="btn btn-primary" value="Войти">
                    </td>
                </tr>
            </table>
        </form>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>