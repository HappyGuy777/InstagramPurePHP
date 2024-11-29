<?php

session_start();
include_once '../config/config.php';
global $connect;
$my_id=$_SESSION['user']['id'];
$word = $_POST['word'];
$search=$_POST['search'];
if ($word) {
    if ($search=='username'||$search=='full_name'){
        $sql = "SELECT * FROM `users` WHERE `$search` LIKE '%$word%' AND `status` = 0";
    }else if ($search=='title'){
        $sql = "SELECT `users`.*,`posts`.`title` FROM `posts` LEFT JOIN `users` ON `users`.`id`=`posts`.`user_id`  WHERE  `posts`.`$search` LIKE '$word%' AND `users`.`status` = 0";
    }

    $result = mysqli_fetch_all(mysqli_query($connect, $sql));
//    $user_id=$result[0];
//    echo json_encode($result);
//    $sql="SELECT *  FROM `followers` WHERE `sender_id`=$my_id AND `receiver_id`=$user_id";
//    $follow_req=mysqli_fetch_assoc(mysqli_query($connect,$sql));

    echo json_encode($result);
} else {
    echo json_encode("empty");
}