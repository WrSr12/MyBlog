<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class AdminsController extends AbstractController
{
    public function main(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Доступ только для администратора');
        }

        $this->view->renderHtml('admins/adminPanel.php', ['user' => $this->user]);
    }

    public function viewArticlesManagement(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Доступ только для администратора');
        }

        $lastArticles = Article::findLastEntriesWithLimit(15);
        $this->view->renderHtml('admins/articlesManagement.php', ['user' => $this->user, 'articles' => $lastArticles]);
    }

    public function viewCommentsManagement(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Доступ только для администратора');
        }

        $lastComments = Comment::findLastEntriesWithLimit(20);
        $this->view->renderHtml('admins/commentsManagement.php', ['user' => $this->user, 'comments' => $lastComments]);
    }

    public function editSiteName(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('');
        }

        if (!empty($_POST['siteName'])) {

            $newSiteName = trim($_POST['siteName']);

            if (empty($newSiteName) || strlen($newSiteName) > 50) {
                throw new InvalidArgumentException('Название сайта не может быть пустым и не может содержать более 50 символов');
            }

            $presentSiteName = (require __DIR__ . '/../../settings.php')['site']['name'];

            $settings = file_get_contents(__DIR__ . '/../../settings.php');
            $settingsWithNewSiteName = str_replace($presentSiteName, $newSiteName, $settings);

            file_put_contents(__DIR__ . '/../../settings.php', $settingsWithNewSiteName);

            header('Location: /administration', true, 302);
            exit();
        }

        throw new InvalidArgumentException('Не найдено новое название сайта в запросе');
    }

}