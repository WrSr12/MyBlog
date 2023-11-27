<?php

namespace MyProject\Models\Comments;

use DateTimeImmutable;
use MyProject\Exceptions\DbException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    /**
     * @var int
     */
    protected $authorId;

    /**
     * @var int
     */
    protected $articleId;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $createdAt;

    protected static function getTableName(): string
    {
        return 'comments';
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

    public static function create(string $text, User $author, int $articleId): Comment
    {
        if (empty($text) || strlen($text) > 300) {
            throw new InvalidArgumentException();
        }

        $comment = new Comment();

        $comment->setAuthor($author);
        $comment->setArticleId($articleId);
        $comment->setText($text);

        $comment->save();

        return $comment;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    /**
     * @param int $articleId
     */
    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
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

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->createdAt);
        return $date->format('d.m.Y') . ' в ' . $date->format('H:i');
    }
}