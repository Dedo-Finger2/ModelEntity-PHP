<?php

namespace app\model;
use app\database\Connection;
use app\entity\UserEntity;

class Post extends Model
{
    protected string $table = "posts";
    protected string $primaryKey = "id_post";

}
