<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ./login.php');
}
require_once '../config/config.php';
global $connect;
$user_id = $_SESSION['user']['id'];

$sql = "SELECT * FROM `posts` WHERE `user_id` = $user_id";
$posts = mysqli_query($connect, $sql);
$post_count = count(mysqli_fetch_all($posts));
$sql = "SELECT `followers`.* FROM `followers` JOIN `users` ON `followers`.`receiver_id` = `users`.`id` WHERE `followers`.`sender_id` = $user_id AND `followers`.`status` = 'accept' AND `users`.`status` = 0";
$following_num = mysqli_num_rows(mysqli_query($connect, $sql));

$sql = "SELECT `followers`.* FROM `followers` JOIN `users` ON `followers`.`sender_id` = `users`.`id` WHERE `followers`.`receiver_id` = $user_id AND `followers`.`status` = 'accept' AND `users`.`status` = 0";
$followers_num = mysqli_num_rows(mysqli_query($connect, $sql));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/modal.css">

    <title>Home1</title>
</head>
<body>

<?php
include '../assets/layout/header.php'
?>


<main>
    <div class="profile-box">

        <div class="image-box">
            <img class="profile-image" src="<?php echo $_SESSION['user']['avatar'] ?>"
                 alt="Profile Picture">
        </div>
        <div class="info-box">
            <div class="profile-info">
                <div class="profile-info-item"><h2><?php echo $_SESSION['user']['username'] ?></h2></div>


                <div class="profile-info-item">
                    <a href="./edit.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-settings">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        </svg>Edit account</a>

                </div>
                <div class="profile-info-item">
                    <a href="./login.php" onclick="return confirm('Do you really want to log out?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-log-out">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Log out
                    </a>

                </div>
            </div>
            <div class="profile-info">
                <div class="profile-info-item">
                    <span class="info-label">Followers</span>
                    <span class="info-value" onclick="following(<?= $user_id?>,'followers')"><?= $followers_num?></span>
                </div>
                <div class="profile-info-item">
                    <span class="info-label">Following</span>
                    <span class="info-value" onclick="following(<?= $user_id?>,'following')"><?= $following_num?></span>
                </div>
                <div class="profile-info-item">
                    <span class="info-label">Posts</span>
                    <span class="info-value"><?php echo $post_count?></span>
                </div>
            </div>
            <div class="profile-info">
                <div class="profile-info-item">
                    <h3><?php echo $_SESSION['user']['full_name'] ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="posts">
        <?php
        $postCount = 0; // Counter to keep track of posts in the current row
        foreach ($posts as $post) {
            $post_id = $post['id'];
            $time = $post['created_at'];
            $sql = "SELECT * FROM `post_images` WHERE `post_id` = $post_id ";
            $images = mysqli_query($connect, $sql);
            $user_id = $_SESSION['user']['id'];
            // Start a new row for every 3 posts
            if ($postCount % 3 === 0) {
                echo '<div class="post-row">';
            }
            ?>

            <div class="post" data-post-id="<?= $post_id ?>">
                <div class="post-title line"><a href="./userProfile.php?user_id=<?= $user_id ?>">
                        <img src="<?= $_SESSION['user']['avatar'] ?>"
                             class="avatar"><?= $_SESSION['user']["username"] ?></a>
                    <div class="date">
                        <p> <?= $time ?></p>

                    </div>
                </div>

                <div class="post-title center">
                    <div class="title_text"><a href=""><span><?= $post['title'] ?></span></a></div>
                    <?php
                    if ($post['user_id'] == $user_id) {
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

                         $sql = "SELECT `likes`.* FROM `likes` WHERE `post_id` = $post_id AND `user_id` = $user_id LIMIT 1";
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
                                    <input type="checkbox"
                                           onchange="like( <?= $post['id'] ?>, <?= $_SESSION['user']['id'] ?>,<?= $like_num ?>)"
                                           id="likeCheck<?= $post['id'] ?>">
                                </label>

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
                        <span>
                            <svg aria-label="Сохранить" class="x1lliihq x1n2onr6" color="rgb(0, 0, 0)"
                                 fill="rgb(0, 0, 0)"
                                 height="24" role="img"
                                 viewBox="0 0 24 24" width="24"><title>Сохранить</title>
                        <polygon fill="none"
                                 points="20 21 12 13.44 4 21 4 3 20 3 20 21"
                                 stroke="currentColor"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 stroke-width="2"></polygon></svg>
                        </span>
                    </div>


                </div>
            </div>

            <?php
            // End the current row after 3 posts
            if ($postCount % 3 === 2) {
                echo '</div>';
            }
            $postCount++;
        }
        ?>
    </div>


</main>

<script src="../assets/js/post.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>
</body>
</html>
