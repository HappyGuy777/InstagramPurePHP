<?php
session_start();
include_once '../config/config.php';
global $connect;
$id = $_POST['image_id'];
$sql = "SELECT * FROM `posts_images` WHERE `id` = $id";
$img = mysqli_fetch_assoc(mysqli_query($connect, $sql))['url'];

$sql = "DELETE FROM `post_images` WHERE `id` = $id";
mysqli_query($connect, $sql);
unlink($img);
