<?php

namespace MyProject\Controllers;

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
                $comment = Comment::create($_POST['text'], $this->user, $articleId);
            } catch (InvalidArgumentException) {
                header('Location: /articles/' . $articleId . '?error#comment', true, 302);
                exit();
            }

            header('Location: /articles/' . $articleId . '#' . $comment->getId(), true, 302);
            exit();
        }
        throw new NotFoundException();
    }

}