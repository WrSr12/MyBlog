<?php

namespace MyProject\Models\Articles;
use MyProject\Exceptions\DbException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Users\User;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Services\Db;

class Article extends ActiveRecordEntity
{
    protected string $name;

    protected string $text;

    protected int $authorId;

    protected ?string $createdAt = null;

    /**
     * @param string[] $fields
     */
    public static function createFromArray(array $fields, User $author): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $article = new Article();


        $article->setAuthor($author);
        $article->setName($fields['name']);
        $article->setText($fields['text']);

        $article->save();


        return $article;
    }

    /**
     * @param string[] $fields
     * @return $this
     * @throws DbException
     * @throws InvalidArgumentException
     */
    public function updateFromArray(array $fields): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $this->setName($fields['name']);
        $this->setText($fields['text']);

        $this->save();

        return $this;
    }

    public function delete(): void
    {
        $sql = 'DELETE FROM ' . static::getTableName() . ' WHERE `id` = :id;';

        $db = Db::getInstance();
        $db->query($sql, [':id' => $this->id], static::class);

        $this->id = null;
    }

    public function getShortText(int $numCharacters): string
    {
        if (mb_strlen($this->getText()) <= $numCharacters) {
            return $this->getText();
        }

        return mb_substr($this->getText(), 0, $numCharacters) . ' ...';
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function getComments(): ?array
    {
        return Comment::getAllByArticleId($this->id);
    }

    public function getCommentsAmount(): string
    {
        return Comment::getAmountByArticle($this->id);
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}