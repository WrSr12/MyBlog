<?php

namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;

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
}