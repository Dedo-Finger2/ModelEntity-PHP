<?php

use app\entity\UserEntity;
use app\model\User;

require __DIR__."/../vendor/autoload.php";

$user = new User();
$users = $user->all();

$userEntity = new UserEntity();
$userEntity->name = "Greg2";
$userEntity->email = "greg2@gmail.com";
$userEntity->setPasswordHash("123453");

var_dump($user->create($userEntity));
var_dump($users);