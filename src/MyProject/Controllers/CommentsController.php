<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class CommentsController extends AbstractController
{
    public function add(int $articleId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $comment = Comment::create($_POST, $this->user, $articleId);
            } catch (InvalidArgumentException $e) {
                $article = Article::getById($articleId);
                $this->view->renderHtml('comments/addFailed.php', ['article' => $article, 'error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $articleId . '#comment' . $comment->getId(), true, 302);
            exit();
        }
        throw new NotFoundException();
    }

    public function edit(int $commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($this->user->getId() !== $comment->getAuthorId() && !$this->user->isAdmin()) {
            throw new ForbiddenException();
        }

        if (!empty($_POST)) {
            try {
                $comment->update($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/editFailed.php', ['comment' => $comment, 'error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $comment->getArticleId() . '#comment' . $comment->getId(), true, 302);
            exit();
        }

        throw new NotFoundException();
    }

    public function delete(int $commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($this->user->getId() !== $comment->getAuthorId() && !$this->user->isAdmin()) {
            throw new ForbiddenException();
        }

        $comment->delete();
        header('Location: /articles/' . $comment->getArticleId() . '#comment-amount', true, 302);
        exit();
    }

}