<?php
session_start();
require_once("../config/config.php");
global $connect;
function clear_data($val)
{
    $val = trim($val);
    $val = stripcslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);
    return $val;
}
if (isset($_POST['add_post'])){
    $title = clear_data($_POST['title']);
    $post_text = clear_data($_POST['post_text']);
    $location= clear_data($_POST['location']);
    $comments= clear_data($_POST['comments']);
    $likes= clear_data($_POST['likes']);
    $hasError=0;
    if (empty($_POST['title'])){
        $hasError=1;
        $_SESSION['error']['add_post']['title']='You dont add post title';
    }else{
        unset($_SESSION['error']['add_post']['title']);
    }
    if ($_FILES['images']['size'][0]==0){
        $hasError = 1;
        $_SESSION['error']['add_post']['empty_image'] = "You dont upload image";
    }else{

        unset($_SESSION['error']['add_post']['empty_image']);
        foreach ($_FILES['images']['name'] as $key => $val){
            if ($key<10){
                unset($_SESSION['error']['add_post']['max_count']);

                $check = getimagesize($_FILES['images']['tmp_name'][$key]);
                if ($check) {
                    unset($_SESSION['error']['add_post']['not_image']);
                } else {
                    $hasError = 1;
                    $_SESSION['error']['add_post']['not_image'] = "One of the files not a image!";
                    header('Location: ../pages/addpost.php');
                }
            }else{
                $hasError = 1;
                $_SESSION['error']['add_post']['max_count'] = "Files max count is 10";
                header('Location: ../pages/addpost.php');
            }
        }
        if ($hasError==0){
            echo "<pre>";
            var_dump($_FILES['images']);
            echo "</pre>";
            $user_id = $_SESSION['user']['id'];
            $hasError = 0;
            $sql = "INSERT INTO `posts`( `title`, `user_id`) VALUES ('$title' , $user_id)";
            mysqli_query($connect, $sql);
            $sql = "SELECT `id` FROM `posts` WHERE `user_id`=$user_id ORDER BY `id` DESC LIMIT 1";
            $lastPostId = mysqli_fetch_assoc(mysqli_query($connect, $sql))['id'];
            echo count($_FILES['images']['name']);
            foreach ($_FILES['images']['name'] as $key => $val) {

                $target_dir = "../uploads/posts/";
                $target_file = $target_dir . time() . basename($val);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $size = $_FILES['images']['size'][$key];
                $allowed_exs = array("jpg", "jpeg", "png", "svg");

                if (file_exists($target_file)) {
                    $hasError = 1;
                    $_SESSION['error']['add_post']['image_exist'] = 'Image already exists!';
                }else{
                    unset($_SESSION['error']['add_post']['image_exist'] );
                }
                if ($size > 5000000) {
                    $_SESSION['error']['add_post']['file_size']= 'File is too large!';
                    $hasError = 1;
                }else{
                    unset($_SESSION['error']['add_post']['file_size']);
                }
                if (!in_array($imageFileType, $allowed_exs)) {
                    $hasError = 1;
                    $_SESSION['error']['add_post']['file_type'] = 'Sorry, only JPG, JPEG, PNG & SVG files are allowed!';
                }else{
                    unset($_SESSION['error']['add_post']['file_type']);
                }
                if ($hasError == 1) {
                    $_SESSION['error']['add_post']['result'] = 'Sorry, your file was not uploaded!';
                } else {
                    unset($_SESSION['error']['add_post']['result']);
                    move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file);
                    $sql="INSERT INTO `post_images` (`url`,`post_id`) VALUES ('$target_file',$lastPostId)";
                    mysqli_query($connect,$sql);
                    header('Location: ../index.php');
                }
            }
        }else{
            echo "Error";
        }
    }
    header('Location: ../pages/addpost.php');
}