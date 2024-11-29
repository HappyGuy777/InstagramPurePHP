<?php
session_start();
require_once '../config/config.php';
global  $connect;
if ($_POST['func'] == 'show_likes') {
    $post_id = $_POST['post_id'];
    $sql = "SELECT `users`.`avatar`,`users`.`username`,`users`.`id` FROM `likes` JOIN `users` ON `likes`.`user_id` = `users`.`id` WHERE `likes`.`post_id` = $post_id AND `users`.`status`=0";
    $users = mysqli_fetch_all(mysqli_query($connect, $sql));
    echo json_encode($users);
}
if ($_POST['func'] == 'show_saves'){
    $post_id = $_POST['post_id'];
    $sql = "SELECT `users`.`avatar`,`users`.`username`,`users`.`id` FROM `saves` JOIN `users` ON `saves`.`user_id` = `saves`.`id` WHERE `saves`.`post_id` = $post_id AND `saves`.`status`=0";
    $users = mysqli_fetch_all(mysqli_query($connect, $sql));
    echo json_encode($users);
}