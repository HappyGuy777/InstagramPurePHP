<?php
session_start();
require_once '../config/config.php';
global $connect;
if (empty($_SESSION['user'])) {
    header('Location: ./login.php');
}
require_once '../config/config.php';
global $connect;

$sql = "SELECT `posts`.*, `users`.`avatar`, `users`.`username`,`users`.`status`
        FROM `posts` JOIN `users` 
        ON `users`.`id` = `posts`.`user_id` ORDER BY `id` DESC ";
$posts = mysqli_query($connect, $sql);
$post_count = count(mysqli_fetch_assoc($posts));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
</head>
<body>
<?php
include '../assets/layout/header.php'
?>
<main>
    <div class="posts">
        <?php
        $postCount = 0; // Counter to keep track of posts in the current row
        foreach ($posts as $post) {
            if ($post['status'] == 0) {
                $post_id = $post['id'];
                $avatar = $post['avatar'];
                $username = $post['username'];
                $time = $post['created_at'];
                $sql = "SELECT * FROM `post_images` WHERE `post_id` = $post_id ";
                $my_id = $_SESSION['user']['id'];
                $user_id = $post['user_id'];
                $images = mysqli_query($connect, $sql);
                if ($postCount % 3 === 0) {
                    echo '<div class="post-row all">';
                } ?>
                <div class="post" data-post-id="<?= $post_id ?>">
                    <div class="post-title line">
                        <a href="./userProfile.php?user_id=<?= $user_id ?>"><img src="<?= $avatar ?>"
                                                                                 class="avatar"><?= $username ?></a>
                        <div class="date">
                            <p> <?= $time ?></p>

                        </div>
                    </div>

                    <div class="post-title center">
                        <div class="title_text"><a href="#"><span><?= $post['title'] ?></span></a></div>
                        <?php
                        if ($post['user_id'] == $my_id) {
                            ?>
                            <a href="./editPost.php?post_id=<?= $post['id'] ?>"">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd"
                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                    <swiper-container class="image-container" pagination="true" pagination-type="fraction"
                                      style='color: grey'>
                        <?php
                        foreach ($images as $img) {
                            ?>
                            <swiper-slide class="image-slide"><img src="<?= $img['url'] ?>"></swiper-slide>
                            <?php
                        }
                        ?>
                    </swiper-container>
                    <div class="post-details">
                        <div class="likes big_cont">
                            <span>
                         <?php

                         $sql = "SELECT `likes`.* FROM `likes` WHERE `post_id` = $post_id AND `user_id` = $my_id LIMIT 1";
                         $hasLike = mysqli_fetch_assoc(mysqli_query($connect, $sql));
                         $sql = "SELECT `likes`.*  FROM `likes` JOIN `users` ON `likes`.`user_id` = `users`.`id` WHERE `likes`.`post_id` = $post_id AND `users`.`status` = 0";
                         $like_num = mysqli_num_rows(mysqli_query($connect, $sql));
                         ?>
                                <label for="likeCheck<?= $post['id'] ?>">
                                    <svg stroke="black" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg" color="rgb(0, 0, 0)"
                                         height="24" width="24" stroke-width="2">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                           stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path id="heart<?= $post['id'] ?>"
                                                  d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z"
                                                  fill="<?= $hasLike ? 'red' : 'white' ?>"></path>
                                        </g>
                                    </svg>

                                </label>
                         <input type="checkbox"
                                onchange="like( <?= $post['id'] ?>, <?= $_SESSION['user']['id'] ?>,<?= $like_num ?>)"
                                id="likeCheck<?= $post['id'] ?>">
                             </span>
                            <span onclick="openModal( <?= $post['id'] ?>)" class="like_count"
                                  id="like_count<?= $post['id'] ?>"><?= $like_num ?></span>


                            <span>
                            <svg aria-label="Комментировать" class="x1lliihq x1n2onr6" color="rgb(0, 0, 0)"
                                 fill="rgb(0, 0, 0)" height="24" role="img" viewBox="0 0 24 24" width="24">
                                <title>Comment</title>
                                <path d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z" fill="none"
                                      stroke="currentColor" stroke-linejoin="round" stroke-width="2">
                                </path>
                            </svg>
                        </span>
                            <span>
                           <svg color="rgb(0, 0, 0)" fill="rgb(0, 0, 0)" height="24" role="img" viewBox="0 0 24 24"
                                width="24"><title>Поделиться публикацией</title>
                               <line fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" x1="22"
                                     x2="9.218" y1="3" y2="10.083"></line>
                               <polygon fill="none" points="11.698 20.334 22 3.001 2 3.001 9.218 10.084 11.698 20.334"
                                        stroke="currentColor" stroke-linejoin="round" stroke-width="2"></polygon>
                           </svg>
                        </span>
                        </div>
                        <div class="likes">
                            <label for="saveCheck<?= $post['id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 384 512" color="black" fill="black" id="save<?= $post_id?>">
                                    <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <?php
                                    $sql = "SELECT `saves`.* FROM `saves` WHERE `post_id` = $post_id AND `user_id` = $my_id LIMIT 1";
                                    $hasSave = mysqli_fetch_assoc(mysqli_query($connect, $sql));
                                    $sql = "SELECT `saves`.*  FROM `saves` JOIN `users` ON `saves`.`user_id` = `users`.`id` WHERE `saves`.`post_id` = $post_id AND `users`.`status` = 0";
                                    $save_num = mysqli_num_rows(mysqli_query($connect, $sql));
                                    ?>
                                       <path id="path<?= $post['id']?>" <?php if ($hasSave){
                                              echo "d='M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z'";

                                    }else{
                                               echo "d='M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z'";
                                     }
                                    ?>/>
                                     </svg>

                            </label>
                            <?php if ($user_id == $my_id) { ?>
                                <span onclick="openModal( <?= $post['id'] ?>,'',true)" class="like_count"
                                      id="save_count<?= $post['id'] ?>"><?= $save_num ?></span>
                                <?php
                            } ?>
                            <input type="checkbox"
                                   onchange="save( <?= $post['id'] ?>, <?= $_SESSION['user']['id']?>, <?php if($hasSave){
                                       echo "true";
                                   }else{
                                       echo "false";
                                   }?>)"
                                   id="saveCheck<?= $post['id'] ?>">
                        </div>


                    </div>

                </div>
                <?php
                // End the current row after 3 posts
                if ($postCount % 3 === 2) {
                    echo '</div>';
                }
                $postCount++; ?>
                <?php
            }
        }
        ?>
    </div>

</main>

<script src="../assets/js/post.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>
</body>
</html>
