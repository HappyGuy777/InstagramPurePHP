<?php
session_start();

require_once ("../config/config.php");
global $connect;
function clear_data($val) {
    $val = trim($val);
    $val = stripcslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);
    return $val;
}

//echo "<pre>";
//var_dump($_POST);
//echo "</pre>";
$register=$_POST['register'];

if (isset($register)) {

    $full_name = clear_data($_POST["full_name"]);
    $username = clear_data($_POST["username"]);
    $email = clear_data($_POST["email"]);
    $gender = $_POST["gender"];
    $password=clear_data($_POST["password"]);
    $hasedpassword = password_hash($password,PASSWORD_DEFAULT) ;
    $confirm_password = clear_data($_POST['confirm_password']);
    $has_Error = 0;
    $sql=mysqli_query($connect,"SELECT `username` FROM `users` WHERE `username`='$username' LIMIT 1");
    $userquery = mysqli_fetch_assoc($sql);
//    var_dump($userquery);
    if (empty($full_name)) {
        $_SESSION["errors"]["register"]["full_name"] = "Full name is empty";
        $has_Error = 1;
    }else{
        unset($_SESSION['errors']['register']['full_name']);
    }
    if (empty($username)) {
        $_SESSION["errors"]["register"]["username"] = "Username is empty";
        $has_Error = 1;
    }else{
        unset($_SESSION['errors']['register']['username']);
        if ($userquery['username']==$username){
            $_SESSION["errors"]["register"]["username_exist"] = "Username already exist";
            $has_Error=1;
        }else{
            unset($_SESSION['errors']['register']['username_exist']);
        }
    }
    $sql=mysqli_query($connect,"SELECT `email` FROM `users` WHERE `email`='$email' LIMIT 1");
    $userquery = mysqli_fetch_assoc($sql);
//    var_dump($userquery);
    if (empty($email)) {
        $_SESSION["errors"]["register"]["email"] = "Email is empty";
        $has_Error = 1;
    }else{
        unset($_SESSION['errors']['register']['email']);
        if ($userquery['email']==$email){
            $_SESSION["errors"]["register"]["email_exist"] = "Email already exist";
            $has_Error=1;
        }else{
            unset($_SESSION['errors']['register']['email_exist']);
        }
    }
    if (empty($password)) {
        $_SESSION["errors"]["register"]["password"] = "Password is empty";
        $has_Error = 1;
    }else{
        unset($_SESSION['errors']['register']['password']);
    }

    if (empty($confirm_password)) {
            $_SESSION["errors"]["register"]["confirm_password_empty"] = "Confirm password is empty";
            $has_Error = 1;
        } else {
        unset($_SESSION["errors"]["register"]["confirm_password_empty"]);
            if ($password == $confirm_password) {
                unset($_SESSION["errors"]["register"]["confirm_password_different"]);
            }else{
                $_SESSION["errors"]["register"]["confirm_password_different"] = "Passwords are different";
                $has_Error = 1;
            }
        }

    if ($has_Error==0) {
        if ($gender == 'male') {
            $avatar= '../uploads/avatars/male.png';

        } else  {
            $avatar= '../uploads/avatars/female.png';

        }
        $sql="INSERT INTO `users` (`full_name`,`username`,`email`,`gender`,`avatar`,`password`,`status`) VALUES ('$full_name', '$username', '$email', '$gender', '$avatar','$hasedpassword',0)";
        mysqli_query($connect,$sql);
    }else{
    }
}



?>
