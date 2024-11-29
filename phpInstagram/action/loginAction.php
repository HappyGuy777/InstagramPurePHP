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
if(isset($_POST['login'])){
    $username = clear_data($_POST['username']);
    $password = clear_data($_POST['password']);

    $hasError = 0;

    if (empty($_POST['username'])){
        $_SESSION["errors"]["login"]["username"]="Username is empty";
        $hasError=1;
    }else{
        unset($_SESSION["errors"]['login']['username']);
    }
    if (!empty($password)){
        if ($hasError==0){
            $sql="SELECT * FROM `users` WHERE(`username`='$username' OR `email`='$username') AND `status`=0 LIMIT 1";
            $user=mysqli_fetch_assoc(mysqli_query($connect ,$sql));
            var_dump($user);
            if ($user==null || $user['status']==1){
                $_SESSION["errors"]["login"]["emailuser"]="Username or email is incorrect or no such user exists";
                $hasError=1;
            }else{
                if ($user['status']==0){
                    unset($_SESSION["errors"]['login']['status']);
                    if (password_verify($password, $user['password'])){
                        unset($_SESSION["errors"]['login']['password']);
                        $_SESSION['user']['id']=$user['id'];
                        $_SESSION['user']['username']=$user['username'];
                        $_SESSION['user']['full_name']=$user['full_name'];
                        $_SESSION['user']['avatar']=$user['avatar'];
                        $_SESSION['user']['email']=$user['email'];

                    header('Location: ../index.php');
                    }else{
                        $_SESSION["errors"]['login']['password']='Password is wrong';
                        $hasError=1;
                    }
                }else{
                    $_SESSION["errors"]['login']['status']='Inactive user';
                    $hasError=1;
                }
            }
            }
    }else{
        $_SESSION["errors"]['login']['passwordempty']='Password is empty';
        $hasError=1;
    }
    if ($hasError==1){
        header("Location: ../pages/login.php");
    }else{
        unset($_SESSION["errors"]['login']);
    }
}else{
        header('Location: ../pages/login.php');
}
?>