<?php
session_start();
require_once("../config/config.php");
global $connect;
$sender_id=$_POST['sender_id'];
$receiver_id=$_POST['receiver_id'];
$follow=$_POST['follow'];
if ($follow=="send"){
    $sql = "INSERT INTO `followers` (`sender_id`,`receiver_id`,`status`) VALUES ('$sender_id','$receiver_id','request')";
}else if ($follow=='delete'){
    $sql = "DELETE FROM `followers` WHERE `sender_id`=$sender_id AND `receiver_id`=$receiver_id";
}else if ($follow=="accept"){
    $sql = "UPDATE `followers` SET `status`='$follow' WHERE `sender_id`='$sender_id' AND `receiver_id`='$receiver_id'";
    echo json_encode('m');
}else if ($follow=="reject"){
    $sql = "DELETE FROM `followers` WHERE `sender_id`=$sender_id AND `receiver_id`=$receiver_id";
}


mysqli_query($connect,$sql);
echo json_encode('$yes');

