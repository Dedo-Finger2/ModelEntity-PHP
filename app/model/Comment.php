<?php

namespace app\model;

class Comment extends Model
{
    protected string $table = "comments";
    protected string $primaryKey = "id_comment";
    public array $relations = [];
}
