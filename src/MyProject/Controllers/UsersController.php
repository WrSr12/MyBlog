<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ActivationException;
use MyProject\Exceptions\DbException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Services\EmailSender;

class UsersController extends AbstractController
{
    public function signUp(): void
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('/users/signUp.php');
    }

    /**
     * @throws ActivationException|DbException
     */
    public function activate(int $userId, string $activationCode): void
    {
        $user = User::getById($userId);

        if ($user === null) {
            throw new ActivationException('Пользователь не найден');
        }

        if ($user->isConfirmed()) {
            throw new ActivationException('Пользователь уже активирован');
        }

        if (!UserActivationService::checkActivationCode($user, $activationCode)) {
            throw new ActivationException('Аккаунт не подтвержден: неверный код активации');
        }

        $user->activate();
        UserActivationService::deleteActivationCode($user, $activationCode);
        $this->view->renderHtml('users/successfulActivation.php');
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        if (isset($_COOKIE['token'])) {
            setcookie('token', '', 0, '/', '', false, true);
        }
        header('Location: /users/login');
        exit();
    }

    public function viewAccount(): void
    {
        $this->view->renderHtml('users/account.php');
    }

    public function viewCommentsManagement(): void
    {
        $comments = Comment::findLastEntriesByColumnWithLimit('author_id', $this->user->getId(), 20);
        $this->view->renderHtml('users/commentsManagement.php', ['comments' => $comments]);
    }

    public function editNickname()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $this->user->updateNickname($_POST);
                header('Location: /users/account');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/editNickname.php', ['error' => $e->getMessage()]);
            }
        }

        $this->view->renderHtml('users/editNickname.php');
    }
}