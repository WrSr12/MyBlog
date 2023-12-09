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

    public static function create(array $post, User $author, int $articleId): Comment
    {
        if (!isset($post['text'])) {
            throw new InvalidArgumentException('В запросе не передан текст комментария');
        }

        $commentText = trim($post['text']);

        if (empty($commentText) || mb_strlen($commentText) > 700) {
            throw new InvalidArgumentException('Комментарий не может быть пустым и не может быть длиннее 700 символов');
        }

        $comment = new Comment();

        $comment->setAuthor($author);
        $comment->setArticleId($articleId);
        $comment->setText($commentText);

        $comment->save();

        return $comment;
    }

    public function update(array $post): Comment
    {
        if (!isset($post['text'])) {
            throw new InvalidArgumentException('В запросе не передан текст комментария');
        }

        $commentText = trim($post['text']);

        if (empty($commentText) || mb_strlen($commentText) > 700) {
            throw new InvalidArgumentException('Комментарий не может быть пустым и не может быть длиннее 700 символов');
        }

        if ($this->getText() === $commentText) {
            throw new InvalidArgumentException('Текст комментария не изменен');
        }

        $this->setText($commentText);

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

    public function getShortText(int $numCharacters): string
    {
        if (mb_strlen($this->getText()) <= $numCharacters) {
            return $this->getText();
        }

        return mb_substr($this->getText(), 0, $numCharacters) . ' ...';
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}