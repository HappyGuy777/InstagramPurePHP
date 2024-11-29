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

if (isset($_POST['add_image'])){
    $title = clear_data($_POST['title']);
    $post_text = clear_data($_POST['post_text']);
    $location= clear_data($_POST['location']);
    $comments= clear_data($_POST['comments']);
    $likes= clear_data($_POST['likes']);
    $post_id=$_GET['post_id'];

    $hasError=0;

    if ($_FILES['images']['size'][0]==0){
        echo 'aakkk';
        $hasError = 1;
        $_SESSION['error']['add_post']['empty_image'] = "You dont upload image";
        header('Location:../pages/error.php');
    } else{
        unset($_SESSION['error']['add_post']['empty_image']);
        $sql ="SELECT * FROM `post_images` WHERE `post_id`=$post_id";
        mysqli_query($connect,$sql);
        $maxcount=10-mysqli_num_rows(mysqli_query($connect,$sql));
        foreach ($_FILES['images']['name'] as $key => $val){
            if ($key<$maxcount){
                unset($_SESSION['error']['add_post']['max_count']);

                $check = getimagesize($_FILES['images']['tmp_name'][$key]);
                if ($check) {
                    unset($_SESSION['error']['add_post']['not_image']);
                } else {
                    $hasError = 1;
                    $_SESSION['error']['add_post']['not_image'] = "One of the files not a image!";
                    echo 'ccc';
                    header('Location: ../pages/error.php');
                }
            }else{
                $hasError = 1;
                $_SESSION['error']['add_post']['max_count'] = 'Files max count is 10 ' . $maxcount;
                echo "abbbb";
                header('Location: ../pages/error.php');
            }
        }
        if ($hasError==0){

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
                    $sql="INSERT INTO `post_images` (`url`,`post_id`) VALUES ('$target_file',$post_id)";
                    mysqli_query($connect,$sql);
                    echo "aaaaaaaaaa";
                    header('Location: ../pages/allposts.php'); ///editpost gnal?
                }
            }
        }else{
            echo "Error";
            header('Location:../pages/error.php');
        }
    }
}