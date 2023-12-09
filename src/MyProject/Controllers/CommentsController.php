<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class CommentsController extends AbstractController
{
    public function add(int $articleId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Добавлять комментарии могут только авторизованные пользователи');
        }

        $article = Article::getById($articleId);

        if (is_null($article)) {
            throw new NotFoundException('Статья не найдена');
        }

        if (!empty($_POST)) {
            try {
                $comment = Comment::create($_POST, $this->user, $articleId);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/add.php', ['article' => $article, 'error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $articleId . '#comment' . $comment->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('comments/add.php', ['article' => $article]);
    }

    public function edit(int $commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Для редактирования комментария необходимо авторизоваться');
        }

        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Комментарий не найден');
        }

        if ($this->user->getId() !== $comment->getAuthorId() && !$this->user->isAdmin()) {
            throw new ForbiddenException('Изменить комментарий может только его автор или администратор');
        }

        if (!empty($_POST)) {
            try {
                $comment->update($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/edit.php', ['comment' => $comment, 'error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $comment->getArticleId() . '#comment' . $comment->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('comments/edit.php', ['comment' => $comment]);
    }

    public function delete(int $commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Комментарий не найден');
        }

        if ($this->user->getId() !== $comment->getAuthorId() && !$this->user->isAdmin()) {
            throw new ForbiddenException('Удалить комментарий может только его автор или администратор');
        }

        $comment->delete();
        header('Location: /articles/' . $comment->getArticleId() . '#comments', true, 302);
        exit();
    }

}