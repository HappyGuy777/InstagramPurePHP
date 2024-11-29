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

if (isset($_POST['edit'])) {
    $fullname_update = clear_data($_POST['full_name']);
    $update_username = clear_data($_POST['username']);
    $update_email = clear_data($_POST['email']);
    $hasError = 0;
    $uploadOk = 1;
    $target_dir = "../uploads/avatars/";
    $target_file = $target_dir . time() . basename($_FILES["update_avatar"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (basename($_FILES["update_avatar"]["name"])) {

        $check = getimagesize($_FILES["update_avatar"]["tmp_name"]);
        if ($check !== false) {
            unset($_SESSION['errors']['edit']['wrong_file']);
        } else {
            $_SESSION['errors']['edit']['wrong_file'] = "File is not an image!";
            $hasError = 1;
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $_SESSION['errors']['edit']['filesize'] = "File is too large!";
            $hasError = 1;
            $uploadOk = 0;
        } else {
            unset($_SESSION['errors']['edit']['filesize']);

        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $_SESSION['errors']['edit']['wrong_filetype'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed!";
            $hasError = 1;
            $uploadOk = 0;
        } else {
            unset($_SESSION['errors']['edit']['wrong_filetype']);

        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['errors']['edit']['dont_upload'] = "Sorry, your file was not uploaded!";
            $hasError = 1;
            // if everything is ok, try to upload file
        } else {
            unset($_SESSION['errors']['edit']['dont_upload']);
            $id = $_SESSION['user']['id'];
            $username = $_SESSION['user']['username'];
            move_uploaded_file($_FILES["update_avatar"]["tmp_name"], $target_file);
            $sql = "UPDATE `users` SET `avatar`='$target_file', `updated_at`= NOW() WHERE `id`='$id' LIMIT 1";
            mysqli_query($connect, $sql);
            $_SESSION['user']['avatar'] = $target_file;
        }
    }

    if (empty($_POST['full_name'])) {
        $_SESSION['errors']["edit"]["full_name"] = "Full name is empty";
        $hasError = 1;
    } else {
        unset($_SESSION['errors']['edit']['full_name']);
    }

    if (empty($_POST['username'])) {
        $_SESSION['errors']["edit"]["username"] = "Username is empty";
        $hasError = 1;
    } else {
        unset($_SESSION['errors']['edit']['username']);
    }
    if (empty($_POST['email'])) {
        $_SESSION['errors']["edit"]["email"] = "Email is empty";
        $hasError = 1;
    } else {
        unset($_SESSION['errors']['edit']['email']);
    }


    if ($hasError == 0) {

        if ($fullname_update != $_SESSION['user']['full_name'] || $update_username != $_SESSION['user']['username'] || $update_email != $_SESSION['user']['email']) {
            $username = $_SESSION['user']['username'];
            $sqluserquery = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id` ,`full_name`, `username`,`email` FROM `users` WHERE `username`='$username' LIMIT 1"));
            if ($sqluserquery['username'] == $update_username && $_SESSION['user']['id'] != $sqluserquery['id']) {
                $_SESSION['errors']["edit"]["using_username"] = "Username is already exist";
                $hasError = 1;
            } else {
                unset($_SESSION['errors']["edit"]["using_username"]);
            }
            if ($sqluserquery['email'] == $update_email && $update_username && $_SESSION['user']['id'] != $sqluserquery['id']) {
                $_SESSION['errors']["edit"]["using_email"] = "Email is already exist";
                $hasError = 1;
            } else {
                unset($_SESSION['errors']["edit"]["using_email"]);
            }
            if ($hasError == 0) {
                $id = $_SESSION['user']['id'];

                    $sql = "UPDATE `users` SET `full_name`='$fullname_update',`username`= '$update_username',`email`='$update_email',`updated_at`= NOW() WHERE `id`='$id' LIMIT 1";
                    mysqli_query($connect, $sql);
                    $sql = "SELECT * FROM `users` WHERE(`username`='$update_username' OR `email`='$update_email') AND `status`=0 LIMIT 1";
                    $user = mysqli_fetch_assoc(mysqli_query($connect, $sql));
                    $_SESSION['user']['username'] = $user['username'];
                    $_SESSION['user']['full_name'] = $user['full_name'];
                    $_SESSION['user']['email'] = $user['email'];
                    header("Location:../pages/profile.php");

            } else {

                header("Location:../pages/edit.php");
            }
        } else {
            $_SESSION['errors']['edit']['same_values'] = "The values are same";
            header('Location: ../pages/edit.php');
        }
    } else {

        header("Location:../pages/edit.php");
    }
} else {
    header("Location:../pages/edit.php");
}


if (isset($_POST['pass_change'])) {
    $current_password = clear_data($_POST['current_password']);
    $new_password = clear_data($_POST['new_password']);
    $repeat_password = clear_data($_POST['repeat_password']);
    $hasErrors = 0;

    if (empty($_POST['current_password'])) {
        $_SESSION['errors']["edit"]["current_password"] = "Current password is empty";
        $hasErrors = 1;
    } else {
        unset($_SESSION['errors']['edit']['current_password']);
    }
    if (empty($_POST['new_password'])) {
        $_SESSION['errors']["edit"]["new_password"] = "New password is empty";
        $hasErrors = 1;
    } else {
        unset($_SESSION['errors']['edit']['new_password']);
    }
    if (empty($_POST['repeat_password'])) {
        $_SESSION['errors']["edit"]["repeat_password_empty"] = "Repeat password  is empty";
        $hasErrors = 1;
    } else {
        unset($_SESSION['errors']['edit']['repeat_password_empty']);
    }
    if ($new_password == $repeat_password) {
        unset($_SESSION['errors']['edit']['repeat_password']);
        if ($hasErrors == 0) {
            $username = $_SESSION['user']['username'];
            $sql = "SELECT * FROM `users` WHERE(`username`='$username') AND `status`=0 LIMIT 1";
            $user = mysqli_fetch_assoc(mysqli_query($connect, $sql));
            if (password_verify($current_password, $user['password'])) {
                unset($_SESSION['errors']['edit']['wrong_password']);
                $id = $_SESSION['user']['id'];
                $hased_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE `users` SET `password`='$hased_password',`updated_at`= NOW() WHERE `id`='$id' LIMIT 1";
                mysqli_query($connect, $sql);
                header("Location:../pages/profile.php");
            } else {
                $_SESSION['errors']['edit']['wrong_password'] = "Entered password is wrong";
                $hasErrors = 1;
            }
        }
    } else {
        $_SESSION['errors']['edit']['repeat_password'] = "Passwords are different";
        $hasErrors = 1;
    }
    if ($hasErrors == 1) {
        header('Location:../pages/edit.php');
    }
}

if (isset($_POST["choice"])){
    $accChoice=$_POST['account_choice'];
    if ($accChoice=="no"){
        header('Location:../pages/edit.php');
    }else{
        $id = $_SESSION['user']['id'];
        $sql = "UPDATE `users` SET `status`='1',`updated_at`= NOW() WHERE `id`='$id' LIMIT 1";
        mysqli_query($connect, $sql);
        header("Location:../pages/login.php");
    }

}

?>
