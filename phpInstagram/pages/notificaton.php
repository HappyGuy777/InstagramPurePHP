<?php
session_start();

require_once '../config/config.php';
global $connect;
$my_id = $_SESSION['user']['id'];
if (empty($my_id)) {
    header('Location:./profile.php');
}
$sql = "SELECT `followers`.* FROM `followers` JOIN `users` ON `followers`.`sender_id` = `users`.`id` WHERE `followers`.`receiver_id` = $my_id AND `followers`.`status` = 'request' AND `users`.`status` = 0";
$follow_req = mysqli_fetch_assoc(mysqli_query($connect, $sql));
$notifications = mysqli_query($connect, $sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/modal.css">

    <title>Home1</title>
</head>
<body>

<?php
include '../assets/layout/header.php'
?>


<main>
    <div class="profile-box notification">

        <?php
        if ($follow_req) {
            foreach ($notifications as $notify) {
                $id = $notify['sender_id'];
                $sql = "SELECT * FROM `users` WHERE  `id`=$id AND `status`=0";
                $user = mysqli_fetch_assoc(mysqli_query($connect, $sql));
                if ($user!=null) {
                    ?>

                    <div class='notify_box' id="notify_user<?php echo $id ?>">
                        <a href="../pages/userProfile.php?user_id=<?php echo $id ?>">
                            <img src="<?php echo $user['avatar'] ?>" alt=""> <?= $user['username'] ?></a>
                        <div>
                            <div>
                                <button onclick="accept(<?= $id ?>,<?= $my_id ?>, 'accept')">Accept</button>
                                <button onclick="accept(<?= $id ?>,<?= $my_id ?>,'reject')">Reject</button>
                            </div>
                        </div>

                    </div>
                    <?php
                }
            }

        } else {
            echo 'No notifications at this moment';
        }
        ?>
    </div>


</main>

<script src="../assets/js/post.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>
</body>
</html>
