<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
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

        $this->view->renderHtml('admins/adminPanelMain.php', ['user' => $this->user]);
    }

    public function editArticles()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Доступ только для администратора');
        }

        $lastArticles = Article::getTheLastEntries(5);

        $this->view->renderHtml('admins/adminPanelArticles.php', ['user' => $this->user, 'articles' => $lastArticles]);
    }

    public function editComments()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Доступ только для администратора');
        }

        $lastComments = Comment::getTheLastEntries(10);

        $this->view->renderHtml('admins/adminPanelComments.php', ['user' => $this->user, 'comments' => $lastComments]);
    }
}