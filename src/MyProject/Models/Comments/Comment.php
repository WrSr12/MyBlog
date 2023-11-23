<?php

namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;

class Comment extends ActiveRecordEntity
{

    protected static function getTableName(): string
    {
        return 'comments';
    }
}