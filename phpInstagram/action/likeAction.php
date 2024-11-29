<?php
session_start();
require_once '../config/config.php';
global  $connect;

$post_id = $_POST['post_id'];
$user_id = $_POST['user_id'];
$status = $_POST["status"];
if($status == "insert"){
    $sql = "INSERT INTO `likes` (`post_id`, `user_id`) VALUES ($post_id, $user_id)";
}else if ($status=="insert_save"){
    $sql = "INSERT INTO `saves` (`post_id`, `user_id`) VALUES ($post_id, $user_id)";
}else if ($status=="delete_save"){
    $sql = "DELETE FROM `saves` WHERE  `user_id` = $user_id  AND `post_id` = $post_id ";
}
else{
    $sql = "DELETE FROM `likes` WHERE  `user_id` = $user_id  AND `post_id` = $post_id ";
}
mysqli_query($connect, $sql);
