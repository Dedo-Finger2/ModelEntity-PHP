<?php

use app\entity\UserEntity;
use app\model\Post;
use app\model\User;

require __DIR__."/../vendor/autoload.php";

$user = new User();
$users = $user->all();

$post = new Post();
$posts = $post->belongsTo(User::class, 'usuario');

// var_dump($posts);


// $userEntity = new UserEntity();
// $userEntity->name = "Greg2";
// $userEntity->email = "greg2@gmail.com";
// $userEntity->setPasswordHash("123453");

// var_dump($user->create($userEntity));
// var_dump($users);
?>

<ul>
    <?php foreach($posts as $post): ?>
        <strong><li><?= $post->title ?></li></strong>
        <ul>
            <li>User: <?= $post->usuario->name ?></li>
        </ul>
    <?php endforeach; ?>
</ul>