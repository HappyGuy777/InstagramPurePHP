<?php
session_start();
require_once '../config/config.php';
global  $connect;
if ($_POST['funcs_type'] == 'following') {
    $users_id = $_POST['users_id'];

    $sql = "SELECT `users`.`username`, `users`.`avatar`,`users`.`id` FROM `followers` JOIN `users` ON `followers`.`receiver_id` = `users`.`id` WHERE `followers`.`sender_id` = $users_id AND `followers`.`status` = 'accept' AND `users`.`status`=0";
    $following = mysqli_fetch_all(mysqli_query($connect, $sql));




    echo json_encode($following);
}
if ($_POST['funcs_type'] == 'followers'){
    $users_id = $_POST['users_id'];
    $sql = "SELECT `users`.`username`, `users`.`avatar`, `users`.`id` FROM `followers` JOIN `users` ON `followers`.`sender_id` = `users`.`id` WHERE `followers`.`receiver_id` = $users_id AND `followers`.`status` = 'accept' AND `users`.`status` = 0";
    $followers = mysqli_fetch_all(mysqli_query($connect, $sql));
    echo json_encode($followers);
}