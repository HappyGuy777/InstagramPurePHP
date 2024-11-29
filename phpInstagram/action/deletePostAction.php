<?php
session_start();
require_once("../config/config.php");
global $connect;
$id=$_GET['post_id'];
if (isset($_POST["choice"])){
    $accChoice=$_POST['account_choice'];
    if ($accChoice=="no"){
        header("Location:../pages/editPost.php?post_id=".$id);
    }else{
        $sql = "SELECT * FROM `post_images` WHERE `post_id` = $id";
        $images=mysqli_query($connect, $sql);
        foreach ($images as $image){
            $img = $image['url'];
            var_dump($img);
            unlink($img);
        }
        $sql = "DELETE FROM `posts` WHERE `id`=$id";
        mysqli_query($connect, $sql);
        header("Location:../pages/allposts.php");
    }

}