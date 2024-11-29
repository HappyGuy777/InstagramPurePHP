<?php
session_start();
require_once ("../config/config.php");
global $connect;
function clear_data($val)
{
    $val = trim($val);
    $val = stripcslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);
    return $val;
}
if (isset($_POST['recover'])){
    $username = clear_data($_POST['username']);
    $password = clear_data($_POST['password']);

    $hasError = 0;

    if (empty($_POST['username'])){
        $_SESSION["errors"]["recover"]["username"]="You dont enter username or E-mail";
        $hasError=1;
    }else{
        unset($_SESSION["errors"]['recover']['username']);
    }
    if (!empty($password)){

        unset($_SESSION["errors"]['recover']['passwordempty']);
        if ($hasError==0){
            $sql="SELECT * FROM `users` WHERE(`username`='$username' OR `email`='$username') AND `status`=1 LIMIT 1";
            $user=mysqli_fetch_assoc(mysqli_query($connect ,$sql));
            var_dump($user);
            if ($user==null){
                $_SESSION["errors"]["recover"]["emailuser"]="Username or email is incorrect or no such inactive user exists";
                $hasError=1;
            }else{
                unset( $_SESSION["errors"]["recover"]["emailuser"]);
                    if (password_verify($password, $user['password'])){
                        unset($_SESSION["errors"]['recover']['password']);
                        $id=$user['id'];
                        $sql="UPDATE `users` SET `status`='0',`updated_at`=NOW() WHERE `id`=$id LIMIT 1";
                        mysqli_query($connect,$sql);
                        header("Location: ../pages/login.php");
                    }else{
                        $_SESSION["errors"]['recover']['password']='Password is wrong';
                        $hasError=1;
                    }
            }
        }
    }else{
        $_SESSION["errors"]['recover']['passwordempty']='Password is empty';
        $hasError=1;
    }
    if ($hasError==1){
        header("Location: ../pages/recover.php");
    }else{
        unset($_SESSION["errors"]['login']);
    }
}else{
    header('Location: ../pages/recover.php');
}
