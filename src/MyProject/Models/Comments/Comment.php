<?php

namespace MyProject\Models\Comments;

use MyProject\Exceptions\DbException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    protected int $authorId;

    protected int $articleId;

    protected string $text;

    protected ?string $createdAt = null;

    public static function createFromArray(array $post, User $author, int $articleId): Comment
    {
        if (!isset($post['addCommentText'])) {
            throw new NotFoundArgumentException('Ошибка при передаче текста комментария');
        }

        $text = trim($post['addCommentText']);

        if (empty($text) || strlen($text) > 150) {
            throw new InvalidArgumentException('Комментарий не может быть пустым и не может быть длиннее 150 символов');
        }

        $comment = new Comment();

        $comment->setAuthor($author);
        $comment->setArticleId($articleId);
        $comment->setText($text);

        $comment->save();

        return $comment;
    }

    public function updateFromArray(array $post): Comment
    {
        if (!isset($post['editCommentText'])) {
            throw new NotFoundArgumentException('Ошибка при передаче текста комментария');
        }

        $text = trim($post['editCommentText']);

        if (empty($text) || strlen($text) > 150) {
            throw new InvalidArgumentException('Комментарий не может быть пустым и не может быть длиннее 150 символов');
        }

        $this->setText($text);

        $this->save();

        return $this;
    }

    public static function getAllByArticleId(int $articleId): ?array
    {
        $db = Db::getInstance();
        $entity = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE article_id = :article_id;',
            [':article_id' => $articleId],
            static::class
        );
        return $entity ?? null;
    }

    public static function getAmountByArticle(int $articleId): string
    {
        if (is_null(self::getAllByArticleId($articleId))) {
            return '0 комментариев';
        }

        $amountComments = count(self::getAllByArticleId($articleId));
        $last_digit = $amountComments % 10;

        if ($last_digit === 1) {
            return $amountComments . ' комментарий';
        }

        if ($last_digit > 1 && $last_digit < 5) {
            if ($amountComments < 12 || $amountComments > 14) {
                return $amountComments . ' комментария';
            }
        }

        return $amountComments . ' комментариев';
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @throws DbException
     */
    public function getAuthorName(): string
    {
        return User::getById($this->authorId)->getNickname();
    }

    /**
     * @throws DbException
     */
    public function getAuthorId(): int
    {
        return User::getById($this->authorId)->getId();
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getArticleName(): string
    {
        return Article::getById($this->articleId)->getName();
    }

    public function getText(): string
    {
        return $this->text;
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}